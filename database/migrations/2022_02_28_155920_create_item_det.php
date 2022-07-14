<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_item_det', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('m_item_id')->nullable();
            $table->char('keterangan', 255)->nullable();
            $table->enum('tipe', ['level', 'topping'])->default('level');
            $table->double('harga')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Generate deleted_at
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
            $table->index('m_item_id');
            $table->index('tipe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_item_det');
    }
}