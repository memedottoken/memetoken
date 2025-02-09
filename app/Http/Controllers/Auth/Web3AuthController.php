<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Signature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class Web3AuthController extends Controller
{
    /**
     * Verify the signature and authenticate the user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {

        try {
            // Validate request
            $validated = $request->validate([
                'address' => 'required|string|starts_with:0x|size:42',
                'signature' => 'required|string|starts_with:0x',
            ]);
            // Get the stored code from session
            $code = session('web3_auth_code');
            if (!$code) return back()->with('error', __('No authentication code found in session'));
            // Verify the signature
            $isValid = Signature::verify(
                $code,
                $validated['signature'],
                $validated['address']
            );

            if (!$isValid) return back()->with('error', __('Invalid signature'));
            // Clear the code from session
            session()->forget('web3_auth_code');
            // Store the verified address in session
            $user = User::query()->firstOrCreate(['address' => $request->address]);
            event(new Registered($user));
            Auth::login($user);
            $request->session()->regenerate();
            return back()->with('success', __('Address verified successfully'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', __('Validation failed'));
        } catch (\Exception $e) {
            return back()->with('error', __('Verification failed'));
        }
    }




    /**
     * code - get an authcode
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function authCode(Request $request)
    {
        $code = Str::random(20);
        session(['web3_auth_code' => $code]);
        return ['authCode' => $code];
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
