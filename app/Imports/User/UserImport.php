<?php

namespace App\Imports;

use App\Models\User\UserModel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserImport implements ToModel, WithUpserts, WithMultipleSheets, WithStartRow, WithValidation
{
    use Importable;
    
    /**
     * Validasi tidak boleh import email yg sudah terdaftar
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            1 => [Rule::unique('user_auth', 'email')], // Table name, field in your db
        ];
    }

    /**
     * Beri label pada urutan kolom untuk ditampilkan jika validasi gagal
     * 
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            1 => 'email'
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new UserModel([
            'nama' => $row[0],
            'email' => $row[1],
            'password' => Hash::make($row[2]),
            'm_roles_id' => $row[3],
        ]);
    }

    /**
    * @return string|array
    */
    public function uniqueBy()
    {
        return 'email';
    }

    /**
     * Sistem akan mulai mengimport data pada baris ke 2
     * karena pada baris pertama adalah header tabel
     *
     * @return integer
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Fungsi untuk memilh sheet yang akan diimport
     * pada contoh ini hanya import untuk sheet pertama saja
     *
     * @return array
     */
    public function sheets(): array
    {
        return [
            0 => $this
        ];
    }
}
