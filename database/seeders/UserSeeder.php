<?php

namespace Database\Seeders;

use App\Models\User\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat database default untuk tabel m_user dan m_roles
 * Jalankan perintah "php artisan db:seed --class=UserSeeder" pada terminal
 */
class UserSeeder extends Seeder
{
    public function run()
    {
        // Input data default untuk tabel m_roles
        DB::table('user_roles')->insert([
            'id' => 1,
            'nama' => 'Super Admin',
            'akses' => '{"user":{"create":true,"update":true,"delete":true,"view":true},"roles":{"create":true,"update":true,"delete":true,"view":true},"books":{"create":true,"update":true,"delete":true,"view":true},"borrow":{"create":true,"update":true,"delete":true,"view":true},"customer":{"create":true,"update":true,"delete":true,"view":true},"item":{"create":true,"update":true,"delete":true,"view":true}}',
        ]);
        DB::table('user_roles')->insert([
            'id' => 2,
            'nama' => 'User',
            'akses' => '{"user":{"create":false,"update":false,"delete":false,"view":false},"roles":{"create":false,"update":false,"delete":false,"view":false},"books":{"create":false,"update":false,"delete":false,"view":true},"borrow":{"create":false,"update":false,"delete":false,"view":true},"book":{"create":false,"update":false,"delete":false,"view":true}}',
        ]);

        // Input data default untuk tabel m_user
        DB::table('user_auth')->insert([
            'id' => 1,
            'user_roles_id' => 1,
            'nama' => 'Wahyu Agung',
            'email' => 'agung@landa.co.id',
            'password' => Hash::make('devGanteng'),
            'updated_security' => date('Y-m-d H:i:s')
        ]);
        UserModel::factory(10)->create();
    }
}