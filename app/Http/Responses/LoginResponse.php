<?php

namespace App\Http\Responses;

use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Usernotnull\Toast\Concerns\WireToast;

class LoginResponse implements LoginResponseContract
{
    use WireToast;
    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        $user = $request->user();

        $redirectUrl = match ($user->role) {
            UserRole::ADMIN => '/admin/dashboard',
            UserRole::STUDENT => '/dashboard',
            default => '/',
        };
        $firstTwo = implode(' ', array_slice(explode(' ', $user->name), 0, 2));

        toast()->success('Berhasil login! Halo ' . $firstTwo)->sticky()->push();
        return redirect()->intended($redirectUrl);
    }
}
