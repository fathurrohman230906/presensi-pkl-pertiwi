<?php

namespace App\Http\Controllers\ProfileUser;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Pembimbing;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelPhone\PhoneNumber;
// use Propaganistas\LaravelPhone\PhoneNumber;

class ProfileUserController extends Controller
{
    public function ProfileUser() {
        $isAdmin = Auth::guard('admin')->check();
        $isPembimbing = Auth::guard('pembimbing')->check();
        $isWali_Kelas = Auth::guard('wali_kelas')->check();
    
        if ($isAdmin) {
            $adminID = session('adminID');
            $DataUser = Admin::where('adminID', $adminID)->first();
            $EditDataUser = Admin::where('adminID', $adminID)->get();
            $fillable = (new Admin)->getFillable();
            $relatedData = null;
        } elseif ($isPembimbing) {
            $pembimbingID = session('pembimbingID');
            $EditDataUser = Pembimbing::where('pembimbingID', $pembimbingID)->get();
            $DataUser = Pembimbing::where('pembimbingID', $pembimbingID)->first();
            $fillable = (new Pembimbing)->getFillable();
            $relatedData = [
                'jurusan' => $DataUser->jurusan ? $DataUser->jurusan->nm_jurusan : null,
            ];
        } elseif ($isWali_Kelas) {
            $waliKelasID = session('wali_kelasID');
            $EditDataUser = WaliKelas::where('wali_kelasID', $waliKelasID)->get();
            $DataUser = WaliKelas::where('wali_kelasID', $waliKelasID)->first();
            $fillable = (new WaliKelas)->getFillable();
            $relatedData = [
                'kelas' => $DataUser->kelas ? $DataUser->kelas->nm_kelas : null,
            ];
        }
    
        $no_tlp = $DataUser->no_tlp;
        // Format phone number using Laravel Phone package
        if ($DataUser->no_tlp) {
            // Provide the country code (e.g., "ID" for Indonesia)
            $phoneNumber = new PhoneNumber($DataUser->no_tlp, 'ID');  // Here 'ID' is the country code for Indonesia
            $DataUser->no_tlp = $phoneNumber->formatInternational();  // Format the number to international format
        }
        // Custom labels for fields
        $customLabels = [
            'email' => 'Email',
            'nm_lengkap' => 'Nama Lengkap',
            'jk' => 'Jenis Kelamin',
            'agama' => 'Agama',
            'no_tlp' => 'Nomor Telepon',
            'alamat' => 'Alamat',
            'kelasID' => 'Kelas',
            'jurusanID' => 'Jurusan',
        ];
    
        $titlePage = "Profile User";
        return view('profileUser.profile-user', compact('titlePage','EditDataUser' ,'no_tlp' , 'DataUser', 'fillable', 'customLabels', 'relatedData'));
    }

    public function EditProfileUser(Request $request) {
        try {
            // Validasi data request
            $DataUser = $request->validate([
                "role" => "required|in:wali_kelas,admin,pembimbing", // Pastikan role valid
                "nm_lengkap" => "required|string",
                "jk" => "required|string",
                "agama" => "required|string",
                "no_tlp" => "required|nullable|between:11,13|regex:/^\d{10,13}$/", // Validasi nomor telepon
                "alamat" => "required|string", // Pastikan alamat merupakan string
                "foto" => "nullable|image|mimes:jpeg,png,jpg,gif", // Foto bersifat opsional
            ]);
    
            $role = $request->role;
    
            if ($role === "admin") {
                // Tambahkan logic untuk admin (jika diperlukan)
                return redirect()->route('profile.user')->with('info', 'Fungsi admin belum tersedia.');
            } elseif ($role === "pembimbing") {
                // Tambahkan logic untuk pembimbing (jika diperlukan)
                // Ambil ID wali kelas dari session
                $pembimbingID = session('pembimbingID');
            
                if (!$pembimbingID) {
                    return redirect()->route('profile.user')->with('peringatan', 'ID Pembimbing tidak ditemukan dalam session.');
                }
    
                // Cari data WaliKelas berdasarkan ID
                $pembimbing = Pembimbing::find($pembimbingID);
    
                if (!$pembimbing) {
                    // Jika WaliKelas tidak ditemukan
                    return redirect()->route('profile.user')->with('peringatan', 'Data Pembimbing tidak ditemukan.');
                }
    
                // Update data pada model WaliKelas
                $pembimbing->nm_lengkap = $DataUser['nm_lengkap'];
                $pembimbing->jk = $DataUser['jk'];
                $pembimbing->agama = $DataUser['agama'];
                $pembimbing->no_tlp = $DataUser['no_tlp'];
                $pembimbing->alamat = $DataUser['alamat'];
    
                // Jika ada foto yang diupload, proses penyimpanan foto
                if ($request->hasFile('foto')) {
                    // Hapus foto lama jika ada
                    if ($pembimbing->foto) {
                        try {
                            Storage::delete('public/FotoProfile/WaliKelas/' . $pembimbing->foto);
                        } catch (\Exception $e) {
                            return redirect()->route('profile.user')->with('peringatan', 'Gagal menghapus foto lama: ' . $e->getMessage());
                        }
                    }
    
                    // Simpan foto baru
                    try {
                        $filePath = $request->file('foto')->store('FotoProfile/Pembimbing', 'public');
                        $pembimbing->foto = basename($filePath);
                    } catch (\Exception $e) {
                        return redirect()->route('profile.user')->with('peringatan', 'Gagal menyimpan foto baru: ' . $e->getMessage());
                    }
                }
    
                // Simpan perubahan ke database
                try {
                    $pembimbing->save();
                } catch (\Exception $e) {
                    return redirect()->route('profile.user')->with('peringatan', 'Gagal menyimpan perubahan: ' . $e->getMessage());
                }
    
                // Redirect dengan pesan sukses
                return redirect()->route('profile.user')->with('success', 'Profile berhasil diubah.');
            } elseif ($role === "wali_kelas") {
                // Ambil ID wali kelas dari session
                $waliKelasID = session('wali_kelasID');
                
                if (!$waliKelasID) {
                    return redirect()->route('profile.user')->with('peringatan', 'ID Wali Kelas tidak ditemukan dalam session.');
                }
    
                // Cari data WaliKelas berdasarkan ID
                $Wali_Kelas = WaliKelas::find($waliKelasID);
    
                if (!$Wali_Kelas) {
                    // Jika WaliKelas tidak ditemukan
                    return redirect()->route('profile.user')->with('peringatan', 'Data Wali Kelas tidak ditemukan.');
                }
    
                // Update data pada model WaliKelas
                $Wali_Kelas->nm_lengkap = $DataUser['nm_lengkap'];
                $Wali_Kelas->jk = $DataUser['jk'];
                $Wali_Kelas->agama = $DataUser['agama'];
                $Wali_Kelas->no_tlp = $DataUser['no_tlp'];
                $Wali_Kelas->alamat = $DataUser['alamat'];
    
                // Jika ada foto yang diupload, proses penyimpanan foto
                if ($request->hasFile('foto')) {
                    // Hapus foto lama jika ada
                    if ($Wali_Kelas->foto) {
                        try {
                            Storage::delete('public/FotoProfile/WaliKelas/' . $Wali_Kelas->foto);
                        } catch (\Exception $e) {
                            return redirect()->route('profile.user')->with('peringatan', 'Gagal menghapus foto lama: ' . $e->getMessage());
                        }
                    }
    
                    // Simpan foto baru
                    try {
                        $filePath = $request->file('foto')->store('FotoProfile/WaliKelas', 'public');
                        $Wali_Kelas->foto = basename($filePath);
                    } catch (\Exception $e) {
                        return redirect()->route('profile.user')->with('peringatan', 'Gagal menyimpan foto baru: ' . $e->getMessage());
                    }
                }
    
                // Simpan perubahan ke database
                try {
                    $Wali_Kelas->save();
                } catch (\Exception $e) {
                    return redirect()->route('profile.user')->with('peringatan', 'Gagal menyimpan perubahan: ' . $e->getMessage());
                }
    
                // Redirect dengan pesan sukses
                return redirect()->route('profile.user')->with('success', 'Profile berhasil diubah.');
            } else {
                return redirect()->route('profile.user')->with('peringatan', 'Role tidak valid.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->route('profile.user')->with('peringatan', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function EditPasswordUser(Request $request) {
        $DataUser = $request->validate([
            "role" => "required|in:wali_kelas,admin,pembimbing",
            "password" => "required|string", 
            "konfirmasi_password" => "required|string", 
        ]);

        $role = $request->role;
    
        if ($role === "admin") {
            // Tambahkan logic untuk admin (jika diperlukan)
            return redirect()->route('profile.user')->with('info', 'Fungsi admin belum tersedia.');
        } elseif ($role === "pembimbing") {
            // Ambil ID wali kelas dari session
            $pembimbingID = session('pembimbingID');
            
            if (!$pembimbingID) {
                return redirect()->route('profile.user')->with('peringatan', 'ID Pembimbing tidak ditemukan dalam session.');
            }

            // Cari data WaliKelas berdasarkan ID
            $pembimbing = Pembimbing::find($pembimbingID);

            if (!$pembimbing) {
                // Jika WaliKelas tidak ditemukan
                return redirect()->route('profile.user')->with('peringatan', 'Data Pembimbing tidak ditemukan.');
            }

            // Update data pada model WaliKelas
            // Check if the passwords match
            if ($DataUser['password'] !== $DataUser['konfirmasi_password']) {
                return redirect()->route('profile.user')->with('peringatan', 'Password Baru dan Konfirmasi Password tidak sama.');
            }
    
            // If the passwords match, proceed to update the password
            $pembimbing->password = bcrypt($DataUser['password']);
            try {
                $pembimbing->save();
            } catch (\Exception $e) {
                return redirect()->route('profile.user')->with('peringatan', 'Gagal menyimpan perubahan: ' . $e->getMessage());
            }

            // Redirect dengan pesan sukses
            return redirect()->route('profile.user')->with('success', 'Passoword berhasil direset.');
        } elseif ($role === "wali_kelas") {
            // Ambil ID wali kelas dari session
            $waliKelasID = session('wali_kelasID');
            
            if (!$waliKelasID) {
                return redirect()->route('profile.user')->with('peringatan', 'ID Wali Kelas tidak ditemukan dalam session.');
            }

            // Cari data WaliKelas berdasarkan ID
            $Wali_Kelas = WaliKelas::find($waliKelasID);

            if (!$Wali_Kelas) {
                // Jika WaliKelas tidak ditemukan
                return redirect()->route('profile.user')->with('peringatan', 'Data Wali Kelas tidak ditemukan.');
            }

            // Update data pada model WaliKelas
            // Check if the passwords match
            if ($DataUser['password'] !== $DataUser['konfirmasi_password']) {
                return redirect()->route('profile.user')->with('peringatan', 'Password Baru dan Konfirmasi Password tidak sama.');
            }
    
            // If the passwords match, proceed to update the password
            $Wali_Kelas->password = bcrypt($DataUser['password']);
            try {
                $Wali_Kelas->save();
            } catch (\Exception $e) {
                return redirect()->route('profile.user')->with('peringatan', 'Gagal menyimpan perubahan: ' . $e->getMessage());
            }

            // Redirect dengan pesan sukses
            return redirect()->route('profile.user')->with('success', 'Passoword berhasil direset.');
        } else {
            return redirect()->route('profile.user')->with('peringatan', 'Role tidak valid.');
        }
    }
       
}
