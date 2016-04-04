<?php

use Illuminate\Database\Seeder;

class ExtensionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extensions')->insert(['name' => 'Kep and Nature','price' => '100']);
        DB::table('extensions')->insert(['name' => 'Koh Rong Island','price' => '100']);
        DB::table('extensions')->insert(['name' => 'Sang Saa Private Island','price' => '100']);
    }
}
