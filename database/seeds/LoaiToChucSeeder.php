<?php

use Illuminate\Database\Seeder;
use App\LoaiToChuc;

class LoaiToChucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
        public function run()
    {
        LoaiToChuc::truncate();

        LoaiToChuc::create(array(
            'ma' => 'MIEN',
            'ten' => 'Miền',
            'company_id' => 2,
            'inactive' => false
        ));
        LoaiToChuc::create(array(
            'ma' => 'CN',
            'ten' => 'Chi nhánh',
            'company_id' => 2,
            'inactive' => false
        ));
        LoaiToChuc::create(array(
            'ma' => 'TINH',
            'ten' => 'Tỉnh',
            'company_id' => 2,
            'inactive' => false
        ));
    }
}
