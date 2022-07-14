<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_item', function (Blueprint $table) {
            $table->id();
            $table->char('nama', 100)->nullable();
            $table->enum('kategori', ['food', 'drink', 'snack'])->default('food');
            $table->double('harga')->nullable();
            $table->text('deskripsi')->nullable();
            $table->char('foto', 255)->nullable();
            $table->enum('is_available', [1, 0])->default(0);
            $table->timestamps();
            $table->softDeletes(); // Generate deleted_at
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);

            $table->index('nama');
            $table->index('kategori');
            $table->index('harga');
            $table->index('is_available');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_item');
    }
}