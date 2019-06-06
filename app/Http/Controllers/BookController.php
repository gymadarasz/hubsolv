<?php

namespace App\Http\Controllers;

use DB;
use App\Book;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'isbn' => 'required|regex:/\d{3}-\d{10}/',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid ISBN'], 400);
        }

        $book = Book::create($request->all());
        
        if ($request->categories) {
            $this->saveCategories($book, $request);
        }
        return response()->json($book, 201);
    }

    /**
     * Store categories of book
     * 
     * @param Book $book
     * @param Request $request
     */
    protected function saveCategories(Book $book, Request $request) {
        $categories = $this->resolveCategories($request);
        foreach ($categories as $category) {
            $categoryId = $this->resolveCategoryId($category);
            if ($categoryId) {
                $bookCategory = \App\BookCategoryRelation::create([
                    'book_id' => $book->id,
                    'category_id' => $categoryId
                ]);
            }
        }
    }

    /**
     * Retrieves an array of given categories, even if it's a comma separated string
     * 
     * @param array|string $request
     * @return array
     */
    protected function resolveCategories($request) {
        if (!is_array($request->categories)) {
            $categories = explode(',', $request->categories);
        } else {
            $categories = $request->categories;
        }
        return $categories;
    }

    /**
     * Resolves a category ID, even if a given category name is a string
     * 
     * @param string|int $category
     * @return int
     */
    protected function resolveCategoryId($category) {
        if (!is_numeric($category)) {
            $categoryTrim = trim($category);
            $categoryId = Category::query()->where('name', 'like', "%$categoryTrim%")->get(['id'])->toArray()[0]['id'];
        } else {
            $categoryId = $category;
        }
        return $categoryId;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book) {
        //
    }

    /**
     * Display a filtered list of the resources.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request) {
        $fields = ['*']; // TODO: add only needed fields
        $books = Book::query();
        if ($request->has('author')) {
            $books->where('author', 'like', '%' . $request->author . '%');
        }
        if ($request->has('category')) {
            $books
                    ->join('book_category_relations', 'books.id', '=', 'book_id')
                    ->join('categories', 'categories.id', '=', 'category_id');
            $books->where('categories.name', 'like', '%' . $request->category . '%');
        }
        if ($request->has('isbn') || $request->isbn) {
            $books->where('isbn', 'like', '%' . $request->isbn . '%');
        }
        return response()->json($books->get($fields));
    }

}
