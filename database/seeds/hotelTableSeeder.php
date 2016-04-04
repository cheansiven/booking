<?php

use Illuminate\Database\Seeder;

class hotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hotel')->insert(['name' => 'Sokha','star' => '5']);
        DB::table('hotel')->insert(['name' => 'Indepandant','star' => '4']);
        DB::table('hotel')->insert(['name' => 'Soksan','star' => '0']);
        DB::table('hotel')->insert(['name' => 'HappyLife','star' => '3']);
    }
}
