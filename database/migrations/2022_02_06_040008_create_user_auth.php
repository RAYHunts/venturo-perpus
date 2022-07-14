<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_auth', function (Blueprint $table) {
            $table->id();
            $table->integer('user_roles_id'); // Membuat kolom m_roles_id dengan tipe data INT
            $table->string('nama', 100); // Membuat kolom "nama" dengan tipe data VARCHAR & 100 karakter
            $table->char('email', 50); // Membuat kolom "email" dengan tipe data CHAR & 50 karakter
            $table->string('password', 255);
            $table->string('foto', 100)->nullable();
            $table->timestamp('updated_security')->nullable(); // Kolom untuk mencatat kapan terakhir kali mengubah data keamanan (password, email)
            $table->enum('is_deleted', [1, 0])->default(0); // Membuat kolom "is_deleted" dengan tipe data ENUM(1,0) dan DEFAULT nya adalah 0
            $table->timestamps(); // Generate created_at & updated_at
            $table->softDeletes(); // Generate deleted_at
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);

            $table->index('user_roles_id'); // Menambah index pada kolom m_roles_id
            $table->index('email');
            $table->index('nama');
            $table->index('updated_security');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_auth');
    }
}
