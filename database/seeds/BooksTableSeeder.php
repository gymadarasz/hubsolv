<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    protected $mock = [
        ['isbn' => '978-1491918661', 'title' => 'Learning PHP, MySQL & JavaScript: With jQuery, CSS & HTML5', 'author' => 'Robin Nixon', 'price' => 9.99, 'currency' => 'GBP'],
        ['isbn' => '978-0596804848', 'title' => 'Ubuntu: Up and Running: A Power User\'s Desktop Guide', 'author' => 'Robin Nixon', 'price' => 12.99, 'currency' => 'GBP'],
        ['isbn' => '978-1118999875', 'title' => 'Linux Bible', 'author' => 'Christopher Negus', 'price' => 19.99, 'currency' => 'GBP'],
        ['isbn' => '978-0596517748', 'title' => 'JavaScript: The Good Parts', 'author' => 'Douglas Crockford', 'price' => 8.99, 'currency' => 'GBP'],
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->truncate();
        foreach ($this->mock as $mock) {
            DB::table('books')->insert($mock);
        }
    }
}
