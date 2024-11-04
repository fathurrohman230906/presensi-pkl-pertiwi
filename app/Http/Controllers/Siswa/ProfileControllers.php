<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class ProfileControllers extends Controller
{
    public function profileSiswa()
    {
        $nis = session('nis');
        $Siswa = Siswa::with('kelas', 'perusahaan')->where('nis', $nis)->get();
        return view('siswa.profile.profile-siswa', [
            "titlePage" => "Profile Siswa",
            "siswa" => $Siswa
        ]);
    }

    public function EditprofileSiswa(Request $request) {
        $dataSiswa = $request->validate([
            'email' => 'required',
            'nm_lengkap' => 'required|string|max:255',
            'agama' => 'required|string',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $siswa = Siswa::find(auth()->user()->nis);
        $siswa->email = $dataSiswa['email'];
        $siswa->nm_lengkap = $dataSiswa['nm_lengkap'];
        $siswa->agama = $dataSiswa['agama'];
        $siswa->alamat = $dataSiswa['alamat'];
    
        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::delete('public/FotoProfile/Siswa/' . $siswa->foto);
            }
    
            $filePath = $request->file('foto')->store('FotoProfile/Siswa', 'public');
            $siswa->foto = basename($filePath);
        }
    
        $siswa->save();
    
        return redirect()->route('profile.siswa')->with('success', 'Profile berhasil di ubah.');
    }
    
    public function EditPasswordSiswa(Request $request) {
        // dd($request->all());
        $dataPasswordSiswa = $request->validate([
            'email' => 'required',
            'password' => 'required|string|min:8|max:20', // Adjusted max length for better user experience
            'KonfirmasiPassword' => 'required|string|min:8|max:20',
        ]);
        
        // Check if the passwords match
        if ($dataPasswordSiswa['password'] !== $dataPasswordSiswa['KonfirmasiPassword']) {
            return redirect()->route('profile.siswa')->with('peringatan', 'Password Baru dan Konfirmasi Password tidak sama.');
        }
    
        // If the passwords match, proceed to update the password
        $siswa = Siswa::find(auth()->user()->nis);
        $siswa->password = bcrypt($dataPasswordSiswa['password']); // Hash the new password
        $siswa->save();
    
        return redirect()->route('profile.siswa')->with('success', 'Password berhasil diubah.');
    }    
}
