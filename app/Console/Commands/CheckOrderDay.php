<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Jobs\CheckOrderDayJob;
class CheckOrderDay extends Command {
    protected $signature = 'app:check-order-day';
    protected $description = 'Check Order Day';

    public function handle()
    {
        /*$ordersSaveDays = SaveRentDay::get();
        if ($ordersSaveDays->count() > 0) {
            foreach ($ordersSaveDays as $ordersSaveDay) {
                $orders = SaveRentDay::findorfail($ordersSaveDay->id);
                if ($ordersSaveDay->status == 'cancel') {
                    $ordersSaveDay->delete();
                    $this->comment('Deleted Orders status cancel');
                }


                if ($ordersSaveDay->start_day == Carbon::now()->format('Y-m-d')) {

                    $timeDifferenceInMinutes = Carbon::now()->diffInMinutes($ordersSaveDay->start_time);

                    if ($timeDifferenceInMinutes == 20) {
                        sendNotificationUser($ordersSaveDay->user->fcm_token, 'من فضلك قم بتأكيد الرحله', 'تأكيد الرحله', true);
                        $orders->update([
                            'status' => "accepted"
                        ]);
                    }

                    if ($timeDifferenceInMinutes == 10) {
                        sendNotificationUser($ordersSaveDay->user->fcm_token, 'من فضلك قم بتأكيد الرحله', 'تأكيد الرحله', true);
                        $orders->update([
                            'status' => "accepted"
                        ]);;
                    }
                    if ($timeDifferenceInMinutes == 5) {
                        sendNotificationUser($ordersSaveDay->user->fcm_token, 'من فضلك قم بتأكيد الرحله', 'تأكيد الرحله', true);
                        $orders->update([
                            'status' => "accepted"
                        ]);
                    }

                    if ($timeDifferenceInMinutes == 1) {
                        sendNotificationUser($ordersSaveDay->user->fcm_token, 'من فضلك قم بتأكيد الرحله', 'تأكيد الرحله', true);
                        $orders->update([
                            'status' => "accepted"
                        ]);
                    }

                    $this->comment('Orders Send ' . $timeDifferenceInMinutes);
                }



                // Check Time Out

                $dataCheck = $ordersSaveDay->start_day . $ordersSaveDay->start_time;
                $dataCheckTimeOut = Carbon::parse($dataCheck)->addMinutes(20)->format('Y-m-d g:i A');
                $dataNowCheckTimeOut =Carbon::now()->format('Y-m-d g:i A');

                if ($dataCheckTimeOut == $dataNowCheckTimeOut){
                    sendNotificationUser($ordersSaveDay->user->fcm_token, 'لقد تم الغاء الرحله لعدم التأكيد', 'الغاء الرحله', true);
                    $ordersSaveDay->delete();
                }




                //Check Orders Sub Dayes

                $dataCheck = $ordersSaveDay->start_day;

                $dataSub = Carbon::now()->subDay()->format('Y-m-d');
                $checks = $dataCheck == $dataSub;
                if ($checks == true){
                    sendNotificationUser($ordersSaveDay->user->fcm_token, 'لقد تم الغاء الرحله لعدم التأكيد', 'الغاء الرحله', true);
                    $ordersSaveDay->delete();
                }

            }
        }*/
        dispatch(new CheckOrderDayJob());
    }
}
