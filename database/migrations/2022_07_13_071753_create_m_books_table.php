<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->text('description')->nullable();
            $table->char('photo', 255)->nullable();
            $table->enum('is_available', [1, 0])->default(0);
            $table->string('publisher')->nullable();
            $table->year('publish_year')->nullable();
            $table->string('author')->nullable();
            $table->integer('qty')->default(0);
            $table->softDeletes();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_books');
    }
}