<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Role;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->validated('avatar')) {
            $user = User::find(auth()->user()->id);
            if ($user->avatar !== 'user_default.jpg') {
                $oldAvatar = 'public/avatar/' . $user->avatar;
                Storage::delete($oldAvatar);
            }

            $name = request()->file('avatar')->getClientOriginalName();
            $avatar = date('Ymd_His') . '_' . $name;
            request()->file('avatar')->storeAs('public/avatar', $avatar);
            $request->user()->avatar = $avatar;
        }

        // print_r($request->user());
        // exit;

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    
    public function index()
    {
        $users = User::all();
        return view('profile.index', compact('users'));
    }

    public function adminedit(User $user) {
        $admin = true;
        $roles = Role::all();

        return view('profile.edit', [
            'user' => $user,
            'admin' => $admin,
            'roles' => $roles
        ]);
    }

    public function adminupdate(Request $request): RedirectResponse
    {
        $inputs = $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($request->user)],
            'avatar' => ['image', 'max:1024'],
            'user' => ['required'],
        ]);

        $user = User::find($request->user);

        if (request()->hasFile('avatar')) {
            if ($user->avatar !== 'user_default.jpg') {
                $oldavatar = 'public/avatar/' . $user->avatar;
                Storage::delete($oldavatar);
            }
            $name = request()->file('avatar')->getClientOriginalName();
            $avatar = date('Ymd_His') . '_' . $name;
            request()->file('avatar')->storeAs('public/avatar', $avatar);
            $user->avatar = $avatar;
        }

        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->save();

        return Redirect::route('profile.adminedit', compact('user'))->with('status', 'profile-updated');
    }
}