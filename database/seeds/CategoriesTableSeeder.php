<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('category')->insert(['name' => 'adventure']);
      DB::table('category')->insert(['name' => 'honeymoon']);
      DB::table('category')->insert(['name' => 'culture']);
      DB::table('category')->insert(['name' => 'adventure']);
      DB::table('category')->insert(['name' => 'honeymoon']);
      DB::table('category')->insert(['name' => 'culture']);
      DB::table('category')->insert(['name' => 'adventure']);
      DB::table('category')->insert(['name' => 'honeymoon']);
      DB::table('category')->insert(['name' => 'culture']);
    }
}
