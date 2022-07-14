<?php

namespace Database\Seeders;

use App\Models\Master\BorrowModel;
use Illuminate\Database\Seeder;

class BorrowModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BorrowModel::factory(200)->create();
    }
}