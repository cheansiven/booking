<?php

use Illuminate\Database\Seeder;

class AddonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('addons')->insert(['name' => 'champagne and sunset','price' => '20']);
      DB::table('addons')->insert(['name' => 'horse carriage','price' => '30']);
      DB::table('addons')->insert(['name' => 'honeymoon package','price' => '100']);
      DB::table('addons')->insert(['name' => 'elephant ride','price' => '20']);
      DB::table('addons')->insert(['name' => 'sport car rental','price' => '20']);
      DB::table('addons')->insert(['name' => 'buffet','price' => '20']);
    }
}
