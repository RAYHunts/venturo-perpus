<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Untuk melakukan migrasi, jalankan perintah "php artisan migrate" pada terminal
 */
class CreateTableRoles extends Migration
{
    /**
     * Method up() adalah method bawaan dari Migration laravel untuk membuat tabel, kolom, dan index.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->char('nama', 50); // Membuat kolom "nama" dengan tipe data CHAR & 50 karakter
            $table->text('akses'); // Membuat kolom "akses" dengan tipe data TEXT
            $table->enum('is_deleted', [1, 0])->default(0); // Membuat kolom "is_deleted" dengan tipe data ENUM(1,0) dan DEFAULT nya adalah 0
            $table->timestamps(); // Generate created_at & updated_at
            $table->softDeletes(); // Generate deleted_at
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);

            $table->index('nama');
        });
    }

    /**
     * Method reverse() adalah method bawaan dari Migration laravel untuk mengembalikan / rollback
     * apa yang dikerjakan pada method up()
     * 
     * Contohnya method up() di atas digunakan untuk membuat tabel user_roles, maka untuk rollbacknya adalah
     * menghapus tabel user_roles tsb
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
