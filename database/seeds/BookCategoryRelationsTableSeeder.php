<?php

use Illuminate\Database\Seeder;
use App\Book;
use App\Category;

class BookCategoryRelationsTableSeeder extends Seeder
{
    protected $mock = [
        ['isbn' => '978-1491918661', 'categories' => ['PHP', 'Javascript']],
        ['isbn' => '978-0596804848', 'categories' => ['Linux']],
        ['isbn' => '978-1118999875', 'categories' => ['Linux']],
        ['isbn' => '978-0596517748', 'categories' => ['Javascript']],
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_category_relations')->truncate();
        foreach ($this->mock as $mock) {
            $bookId = Book::query()->where('isbn', $mock['isbn'])->get(['id'])->toArray()[0]['id'];
            foreach ($mock['categories'] as $category) {
                $categoryId = Category::query()->where('name', $category)->get(['id'])->toArray()[0]['id'];
                DB::table('book_category_relations')->insert([
                    'book_id' => $bookId,
                    'category_id' => $categoryId
                ]);
            }
        }
    }
}
