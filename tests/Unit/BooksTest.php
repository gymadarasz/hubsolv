<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

class BooksTest extends TestCase
{
    /**
     * A basic unit test.
     *
     * @return void
     */
    public function testGetAllBooks()
    {
        $request = Request::create('/api/books');
        $controller = new BookController();
        $response = $controller->index($request);
        $contents = $response->content();
        $this->assertStringContainsString('978-1491918661', $contents);
        $this->assertStringContainsString('978-0596804848', $contents);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testGetBookByAuthor() {
        $request = Request::create('/api/books/filter?author=Robin%20Nixon');
        $controller = new BookController();
        $response = $controller->filter($request);
        $contents = $response->content();
        $this->assertStringContainsString('978-1491918661', $contents);
        $this->assertStringContainsString('978-0596804848', $contents);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testGetBookByCategory() {
        $request = Request::create('/api/books/filter?category=Linux');
        $controller = new BookController();
        $response = $controller->filter($request);
        $contents = $response->content();
        $this->assertStringContainsString('978-0596804848', $contents);
        $this->assertStringContainsString('978-1118999875', $contents);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testGetBookByCategoryAndAuthor() {
        $request = Request::create('/api/books/filter?category=PHP&author=Robin Nixon');
        $controller = new BookController();
        $response = $controller->filter($request);
        $contents = $response->content();
        $this->assertStringContainsString('978-1491918661', $contents);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testGetOneBookOnly() {
        $request = Request::create('/api/books/filter?isbn=978-1491918661');
        $controller = new BookController();
        $response = $controller->filter($request);
        $contents = $response->content();
        $this->assertStringContainsString('978-1491918661', $contents);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testGetOneBookOnly2() {
        $request = Request::create('/api/book/978-1491918661');
        $controller = new BookController();
        $response = $controller->filter($request);
        $contents = $response->content();
        $this->assertStringContainsString('978-1491918661', $contents);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testGetAllCategories() {
        $request = Request::create('/api/categories');
        $controller = new CategoryController();
        $response = $controller->index($request);
        $contents = $response->content();
        $this->assertStringContainsString('PHP', $contents);
        $this->assertStringContainsString('Linux', $contents);
        $this->assertStringContainsString('Javascript', $contents);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testStoreBook() {
        $request = Request::create('/api/books/add', 'POST', [
            "isbn" => "978-1491905012",
            "title" => "Modern PHP: New Features and Good Practices",
            "author" => "Josh Lockhart",
            "categories" => "PHP",
            "price" => "18.99",
            "currency" => "GBP",
        ]);
        $controller = new BookController();
        $response = $controller->store($request);
        $contents = $response->content();
        $this->assertStringContainsString('978-1491905012', $contents);
        $this->assertEquals(201, $response->getStatusCode());
    }
    
    public function testStoreBookShouldFails() {
        $request = Request::create('/api/books/add', 'POST', [
            "isbn" => "978-INVALID-1491905012",
            "title" => "Modern PHP: New Features and Good Practices",
            "author" => "Josh Lockhart",
            "categories" => "PHP",
            "price" => "18.99",
            "currency" => "GBP",
        ]);
        $controller = new BookController();
        $response = $controller->store($request);
        $contents = $response->content();
        $this->assertStringContainsString('Invalid ISBN', $contents);
        $this->assertEquals(400, $response->getStatusCode());
    }
    
    
}
