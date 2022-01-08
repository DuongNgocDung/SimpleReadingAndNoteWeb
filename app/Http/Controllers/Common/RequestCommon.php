<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

trait RequestCommon
{
    public function whenUserHaveRegistered(Request $request)
    {
        return (($request->filled('user_id') && $request->get('user_id') !== '') || !empty(session()->get('login.user_id')))
            && !empty(session()->get('login.user_token'));
    }

    public function whenUserDontHaveAToken(Request $request)
    {
        // return $request->bearerToken() === null && $request->bearerToken() !== '';
    }
}