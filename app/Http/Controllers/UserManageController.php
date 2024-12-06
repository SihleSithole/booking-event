<?php

namespace App\Http\Controllers;



use App\Models\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class UserManageController extends Controller
{

    /**
     * Admin Delete user's account.
     */


    public function removeUser(Request $request): RedirectResponse
    {

        $user_id = $request->delete_user;

        $user = User::findOrFail($user_id);

        $user->delete();

        $role = 'admin';

        return redirect(route('dashboard',  ['identifier' => $role],  absolute:  false));
    }

    /*
     * Admin Update User Account
     * */




}



