<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mypage()
    {
        $user = auth()->user();

        return view('profile.mypage', compact('user'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {

        $user = auth()->user();

        $request->validate([
            'username' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user->username = $request->username;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        if (session()->pull('first_login')) {
            return redirect()->route('home')->with('success', 'プロフィールを設定しました。');
        }

        return redirect()->route('mypage.show')->with('success', 'プロフィールを更新しました。');
    }
}
