<?php

namespace Database\Seeders;

use App\Models\Master\BooksModel;
use Illuminate\Database\Seeder;

class BooksModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BooksModel::factory(200)->create();
    }
}