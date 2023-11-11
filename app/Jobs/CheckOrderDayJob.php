<?php
namespace App\Jobs;
use App\Models\SaveRentDay;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue,SerializesModels};
use Illuminate\Support\Carbon;
class CheckOrderDayJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function handle() {
        $ordersSaveDays = SaveRentDay::get();
        if ($ordersSaveDays->count() > 0) {
            foreach ($ordersSaveDays as $ordersSaveDay) {
                if ($ordersSaveDay->status == 'cancel') {
                    $ordersSaveDay->delete();
                    continue;
                }
                $this->checkAndSendNotifications($ordersSaveDay);
                $this->checkAndHandleTimeout($ordersSaveDay);
                $this->checkAndHandlePreviousDayOrders($ordersSaveDay);
            }
        }
    }

    protected function checkAndSendNotifications(SaveRentDay $ordersSaveDay) {
        $timeDifferenceInMinutes = Carbon::now()->diffInMinutes($ordersSaveDay->start_time);
        if (in_array($timeDifferenceInMinutes, [20, 10, 5, 1])) {
            sendNotificationUser($ordersSaveDay->user->fcm_token, 'من فضلك قم بتأكيد الرحله', 'تأكيد الرحله', true);
            $ordersSaveDay->update([
                'status' => "accepted"
            ]);
            $this->info('Orders Send ' . $timeDifferenceInMinutes);
        }
    }

    protected function checkAndHandleTimeout(SaveRentDay $ordersSaveDay) {
        $dataCheck = $ordersSaveDay->start_day . $ordersSaveDay->start_time;
        $dataCheckTimeOut = Carbon::parse($dataCheck)->addMinutes(20)->format('Y-m-d g:i A');
        $dataNowCheckTimeOut = Carbon::now()->format('Y-m-d g:i A');
        if ($dataCheckTimeOut == $dataNowCheckTimeOut) {
            sendNotificationUser($ordersSaveDay->user->fcm_token, 'لقد تم الغاء الرحله لعدم التأكيد', 'الغاء الرحله', true);
            $ordersSaveDay->delete();
        }
    }

    protected function checkAndHandlePreviousDayOrders(SaveRentDay $ordersSaveDay) {
        $dataCheck = $ordersSaveDay->start_day;
        $dataSub = Carbon::now()->subDay()->format('Y-m-d');
        $checks = $dataCheck == $dataSub;
        if ($checks) {
            sendNotificationUser($ordersSaveDay->user->fcm_token, 'لقد تم الغاء الرحله لعدم التأكيد', 'الغاء الرحله', true);
            $ordersSaveDay->delete();
        }
    }
}
