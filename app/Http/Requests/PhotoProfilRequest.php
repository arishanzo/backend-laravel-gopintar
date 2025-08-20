<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File as FileRule;

class PhotoProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'foto_profil' => [
                'nullable',
                'file',
                FileRule::image()
                    ->types(['jpg','jpeg','png','webp'])
                    ->max(5 * 1024) // 5 MB
                    ->dimensions(fn($rule) => $rule->maxWidth(4000)->maxHeight(4000)),
                  ],

            'alamatlengkap' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:10',
            'nama_anak' => 'required|string|max:255',
            'usia_anak' => 'required|integer|min:1|max:100',
        ];
    }

     public function messages(): array
    {
        return [
           'foto_profil.file' => 'File harus berupa gambar.',
        'foto_profil.mimes' => 'File harus berupa gambar dengan format jpg, jpeg, png, atau webp.',
        'foto_profil.max' => 'Ukuran file tidak boleh melebihi 5 MB.',
        'no_telp.required' => 'Nomor telepon harus diisi.',
        'no_telp.max' => 'Nomor telepon tidak boleh melebihi 12 digit.',
        'provinsi.required' => 'Provinsi harus diisi.',
        'provinsi.max' => 'Provinsi tidak boleh melebihi 255 karakter.',
        'kabupaten.required' => 'Kabupaten harus diisi.',
        'kabupaten.max' => 'Kabupaten tidak boleh melebihi 255 karakter.',
        'kecamatan.required' => 'Kecamatan harus diisi.',
        'kecamatan.max' => 'Kecamatan tidak boleh melebihi 255 karakter.',
        'kelurahan.required' => 'Kelurahan harus diisi.',
        'kelurahan.max' => 'Kelurahan tidak boleh melebihi 255 karakter.',
        'kode_pos.required' => 'Kode pos harus diisi.',
        'kode_pos.max' => 'Kode pos tidak boleh melebihi 12 digit.',
        'nama_anak.required' => 'Nama anak harus diisi.',
        'nama_anak.max' => 'Nama anak tidak boleh melebihi 255 karakter.',
        'usia_anak.required' => 'Usia anak harus diisi.',
        'usia_anak.max' => 'Usia anak tidak boleh melebihi 255 karakter.',
        'alamatlengkap.required' => 'Alamat lengkap harus diisi.',
        'alamatlengkap.max' => 'Alamat lengkap tidak boleh melebihi 255 karakter.',
    
        ];
    }
}
