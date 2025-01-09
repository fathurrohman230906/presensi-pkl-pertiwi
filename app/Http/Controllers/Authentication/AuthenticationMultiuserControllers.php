<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Kelas;
use App\Models\Siswa;

class AuthenticationMultiuserControllers extends Controller
{
    public function LoginUsers()
    {
        return view('authentication.loginUser', [
            "titlePage" => "Login User"
        ]);
    }

    public function AuthenticationLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8|max:8'
        ];
    
        $request->validate($rules);
    
        $credentials = $request->only('email', 'password');
    
        $guards = ['admin', 'pembimbing', 'siswa', 'wali_kelas'];
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials)) {
                $request->session()->regenerate();
                
                // Get the user from the specific guard
                $user = Auth::guard($guard)->user();
                $request->session()->put('role', $guard);
                
                // dd($guard);
                switch ($guard) {
                    case 'admin':
                        $request->session()->put('adminID', $user->adminID);
                        $request->session()->put('nm_lengkap', $user->nm_lengkap);
                        $request->session()->put('role', 'admin');
                        return redirect('/admin-dashboard')->with('success', 'Anda berhasil login');
    
                    case 'pembimbing':
                        $request->session()->put('pembimbingID', $user->pembimbingID);
                        $request->session()->put('nm_lengkap', $user->nm_lengkap);
                        $request->session()->put('level', $user->level);
                        return redirect('/pembimbing-dashboard')->with('success', 'Anda berhasil login');
    
                    case 'siswa':
                        $request->session()->put('siswaID', $user->siswaID);
                        $request->session()->put('nm_lengkap', $user->nm_lengkap);
                        $request->session()->put('nis', $user->nis);
                        $request->session()->put('role', 'siswa');
                        return redirect('/siswa-dashboard')->with('success', 'Anda berhasil login');
    
                    case 'wali_kelas':
                        $request->session()->put('wali_kelasID', $user->wali_kelasID);
                        $request->session()->put('nm_lengkap', $user->nm_lengkap);
                        $request->session()->put('role', 'wali_kelas');
                        return redirect('/siswa-dashboard')->with('success', 'Anda berhasil login');
                }
            }
        }
    
        return redirect()->route('login.user')->with('loginError', 'Login gagal, silahkan coba lagi.');
    }

    public function logout(Request $request)
    {
        // dd($request->all());
        $role = $request->input('role');

        // $nama_lengkap = '';
    
        switch ($role) {
            case 'admin':
                $admin = Auth::guard('admin')->user();
                $nama_lengkap = $admin->nm_lengkap;
                Auth::guard('admin')->logout();
                break;
            case 'pembimbing':
                $pembimbing = Auth::guard('pembimbing')->user();
                $nama_lengkap = $pembimbing->nm_lengkap;
                Auth::guard('pembimbing')->logout();
                break;
            case 'wali_kelas':
                $wali_kelas = Auth::guard('wali_kelas')->user();
                $nama_lengkap = $wali_kelas->nm_lengkap;
                Auth::guard('wali_kelas')->logout();
                break;
            case 'siswa':
                $siswa = Auth::guard('siswa')->user();
                $nama_lengkap = $siswa->nm_lengkap;
                Auth::guard('siswa')->logout();
                break;
            default:
                return redirect()->route('login.user')->with('errorLogout', 'Role tidak valid.');
        }
    
        // Clear all session data
        session()->flush();
    
        // Flash the session data for the redirect
        // session()->flash('nama_lengkap', $nama_lengkap);
    
        // Redirect to login.user route
        return redirect()->route('login.user')->with('logout', 'Anda telah berhasil keluar sebagai ' . $nama_lengkap);
    }
}
