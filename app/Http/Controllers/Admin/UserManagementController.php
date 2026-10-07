<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = User::where('role', 'user');

        if($search){
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => [
                'required', 'string', 'max:20',
                Rule::unique('users')->ignore($user->user_id, 'user_id')
            ],
            'email' => [
                'required', 'string', 'email', 'max:100',
                Rule::unique('users')->ignore($user->user_id, 'user_id')
            ],
        ]);

        $user->nama = $request->nama;
        $user->nim = $request->nim;
        $user->email = $request->email;

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->role == 'admin' || $user->user_id == Auth::id()){
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat mengapus admin');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User Berhasil dihapus');
    }
}
