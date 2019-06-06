<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    protected $mock = [
        ['name' => 'PHP'],
        ['name' => 'Linux'],
        ['name' => 'Javascript'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();
        foreach ($this->mock as $mock) {
            DB::table('categories')->insert($mock);
        }
    }
}
