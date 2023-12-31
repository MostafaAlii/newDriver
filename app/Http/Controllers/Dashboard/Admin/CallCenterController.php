<?php
namespace App\Http\Controllers\Dashboard\Admin;
use App\DataTables\Dashboard\Admin\CallCenterDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\CallCenterRequestValidation;
use App\Services\Dashboard\Admins\CallCenterService;
use App\Services\Dashboard\General\GeneralService;
use Illuminate\Http\Request;
class CallCenterController extends Controller {
    public function __construct(protected CallCenterDataTable $dataTable, protected CallCenterService $callCenterService, protected GeneralService $generalService) {
        $this->dataTable = $dataTable;
        $this->callCenterService = $callCenterService;
        $this->generalService = $generalService;
    }

    public function index() {
        $data = [
            'title' => 'Call-Centers',
            'countries' => $this->generalService->getCountries(),
        ];
        return $this->dataTable->render('dashboard.admin.call-centers.index',  compact('data'));
    }

    public function show($callCenterId) {
        try {
            $data = [
                'title' => 'Call-Center Details',
                'callCenter' => $this->callCenterService->getProfile($callCenterId),
            ];
            return view('dashboard.admin.call-centers.show', compact('data'));
        } catch (\Exception $e) {
            return redirect()->route('callCenters.index')->with('error', 'An error occurred while getting the callCenters details');
        }
    }

    public function store(CallCenterRequestValidation $request) {
        try {
            $requestData = $request->validated();
            $this->callCenterService->create($requestData);
            return redirect()->route('callCenters.index')->with('success', 'Call-Center created successfully');
        } catch (\Exception $e) {
            return redirect()->route('callCenters.index')->with('error', 'An error occurred while creating the call-center');
        }
    }

    public function update(CallCenterRequestValidation $request, $callCenterId) {
        try {
            $requestData = $request->validated();
            $this->callCenterService->update($callCenterId, $requestData);
            return redirect()->route('callCenters.index')->with('success', 'Call-Center updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('callCenters.index')->with('error', 'An error occurred while updating the call-center');
        }
    }

    public function updatePassword(Request $request, $callCenterId) {
        try {
            $this->callCenterService->updatePassword($callCenterId, $request->password);
            return redirect()->route('callCenters.index')->with('success', 'Call-Center password updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('callCenters.index')->with('error', 'An error occurred while updating the call-center password');
        }
    }

    public function updateStatus(Request $request, $callCenterId) {
        try {
            $this->callCenterService->updateStatus($callCenterId, $request->status);
            return redirect()->route('callCenters.index')->with('success', 'Call-Center password updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('callCenters.index')->with('error', 'An error occurred while updating the Call-Center');
        }
    }

    public function destroy($id) {
        try {
            $this->callCenterService->delete($id);
            return redirect()->route('callCenters.index')->with('success', 'Call-Center deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('callCenters.index')->with('error', 'An error occurred while deleting the call-center');
        }
    }
}
