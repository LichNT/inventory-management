<?php

use Illuminate\Database\Seeder;
use App\LoaiPhongBan;

class LoaiPhongBanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoaiPhongBan::truncate();

        LoaiPhongBan::create(array(
            'ma' => 'P',
            'ten' => 'Phòng',
            'company_id' => 2,
            'trang_thai' => '1',
        ));
        LoaiPhongBan::create(array(
            'ma' => 'BP',
            'ten' => 'Bộ phận',
            'company_id' => 2,
            'trang_thai' => '1',
        ));
    }
}
