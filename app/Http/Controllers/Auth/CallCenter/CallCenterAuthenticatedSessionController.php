<?php
namespace App\Http\Controllers\Auth\CallCenter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CallCenter\CallCenterLoginRequest;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class CallCenterAuthenticatedSessionController extends Controller {
    public function create(): View {
        return view('auth.callCenter.login');
    }

    public function store(CallCenterLoginRequest $request): RedirectResponse {
        $request->authenticate($request);
        $request->session()->regenerate();
        return redirect()->route('callCenter.dashboard');
    }

    public function destroy(Request $request): RedirectResponse {
        Auth::guard('call-center')->logout();
        $request->session()->forget('guard.call-center');
        $request->session()->regenerateToken();
        return redirect()->route('callCenter.login');
    }
}
