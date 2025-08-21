<?php

namespace App\Http\Controllers\User;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhotoProfilRequest;
use App\Models\ProfilUser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UserProfileController extends Controller
{
    
    public function getAll () {

        return ProfilUser::all();

    }

    public function getByID ($iduser) {
        
    //  $profil = ProfilUser::with('User_Login')->where('iduser', $iduser)->first();

        $profil = Cache::remember("profil_$iduser", 60, function() use($iduser) {
            return ProfilUser::with('User_Login')->where('iduser', $iduser)->first();
        });


        return response()->json([
            'data' => $profil,
            'message' => $profil ? 'Profil Ada' : 'Profil Tidak Ada'
        ]);

    }

    public function store (PhotoProfilRequest $request) {

        $user = $request->user();
        if (!$user) {
            return response()->json([
                'message' => 'User tidak terautentikasi'
            ], 401);
        }

        $data = $request->validated();
        $data['iduser'] = $user->iduser;

        
         $cekprofil = ProfilUser::where('iduser', $user->iduser)->first();

        
        if ($request->hasFile('foto_profil')) {

              if ($cekprofil->foto_profil && Storage::disk(env('PHOTO_PRIVATE_DISK', 'private'))->exists($cekprofil->foto_profil)) {
            Storage::disk(env('PHOTO_PRIVATE_DISK', 'private'))->delete($cekprofil->foto_profil);
           }
       

            $file = $request->file('foto_profil');

           $image = Image::make($file)->encode('webp', 80);

            $encoded = (string) $image->encode();

            $disk = env('PHOTO_PRIVATE_DISK', 'private');
            
            $filename = Str::uuid()->toString().'.webp';

            $path = 'photos/'.date('Y/m/d').'/'.$filename;

            $data['foto_profil'] = $path;
            
            Storage::disk($disk)->put($path, $encoded, 'private');
        } else {
        unset($data['foto_profil']); // jangan overwrite kolom lama kalau tidak ada upload
       }

       $cekprofil = ProfilUser::where('iduser', $user->iduser)->first();

       if($cekprofil){
        $cekprofil->update($data);
       } else {
        ProfilUser::create($data);
       }

        return response()->json([
            'message' => 'Profile Berhasil Disimpan',
        ], 201);

    }   

    public function update (PhotoProfilRequest $request, $idprofiluser) {

 $user = $request->user();
    if (!$user) {
        return response()->json([
            'message' => 'User tidak terautentikasi'
        ], 401);
    }

    $data = $request->validated();
    $data['iduser'] = $user->iduser;

    $profil = ProfilUser::findOrFail($idprofiluser);

    if ($request->hasFile('foto_profil')) {

        // Hapus foto lama kalau ada
      
        if ($profil->foto_profil && Storage::disk(env('PHOTO_PRIVATE_DISK', 'private'))->exists($profil->foto_profil)) {
            Storage::disk(env('PHOTO_PRIVATE_DISK', 'private'))->delete($profil->foto_profil);
        }
       
        $file = $request->file('foto_profil');
        $binary = file_get_contents($file->getRealPath());

        $image = Image::make($binary)->encode('webp', 85);
        $encoded = (string) $image;


        $disk = env('PHOTO_PRIVATE_DISK', 'private');
        $filename = Str::uuid()->toString() . '.webp';
        $path = 'photos/' . date('Y/m/d') . '/' . $filename;
        

        $data['foto_profil'] = $path;
     Storage::disk($disk)->put($path, $encoded, ['visibility' => 'private']);

        
     } else {
        unset($data['foto_profil']);
    }

    $profil->update($data);

    return response()->json([
        'message' => 'Profile berhasil diperbarui',
    ], 200);

    }

    public function destroy () {

    }

    
}
