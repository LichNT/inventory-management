<?php

namespace App\Http\Controllers;

use App\Menu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Exception;
use App\Traits\GetDataCache;

class ProfileController extends Controller
{
    use GetDataCache;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();                

        return view('auth.profile', 
            ['menus' => $this->getMenusForUser($user), 'user' => $user]);
    }

    /**
     * Handle a update profile request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $info = $request->only('name');

        $validator = Validator::make($info, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('user.update_user_error'));
        }

        $user = Auth::user();

        User::query()->find($user->id)
            ->update($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function changePassword(Request $request,$id)
    {
        $info = $request->all();

        $validator = Validator::make($info, [
            'password' => 'required',
            'new_password' => 'required|max:255|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('user.update_password_error'));
        }

        $user = Auth::user();

        if (!Hash::check($info['password'], $user->password)) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('user.password_wrong'));
        }

        User::query()
            ->find($user->id)
            ->update(['password' => Hash::make($info['new_password'])]);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('user.update_password_success'));
    }
}
