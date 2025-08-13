<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
            ]
        );
        $newRequest = $request->all();
        if (!$id) {
            $newRequest['password'] = bcrypt('password');
        }
        User::updateOrCreate(
            ['id' => $id],
            $newRequest
        );
        toast()->success('User berhasil disimpan');
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    public function gantiPassword(Request $request)
    {
        $request->validate(
            [
                'old_password' => 'required',
                'password' => 'required|min:6|confirmed',
                // yang ini adalah aturan untuk password baru yang benar-benar kuat
                // 'password' => [ Password::min(6)
                //     ->letters()
                //     ->mixedCase()
                //     ->numbers()
                //     ->symbols()| 'confirmed'],
            ],
            [
                'old_password.required' => 'Password lama tidak boleh kosong',
                'password.required' => 'Password baru tidak boleh kosong',
                'password.min' => 'Password baru minimal 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
            ]
        );

        // cek apakah password lama sesuai dengan yang ada di database
        // jika tidak sesuai, kembalikan error
        $user = User::findOrFail(Auth()->user()->id);
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Password lama tidak cocok']);
        }
    //    jika sesuai, update password baru
        $user->update([
            'password' => bcrypt($request->password),
        ]);
        toast()->success('Password berhasil diubah');
        return redirect()->route('users.index');

        
    }
}
