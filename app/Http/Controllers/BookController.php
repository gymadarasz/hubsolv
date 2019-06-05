<?php

namespace App\Http\Controllers;

use DB;
use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
    
    /**
     * Display a filtered list of the resources.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request) {
        $books = Book::query();
        if ($request->has('author')) {
            $books->where('author', 'like', '%' . $request->author . '%');
        }
        if ($request->has('category')) {
            $books->where('category', 'like', '%' . $request->category . '%');
        }
        return response()->json($books->get(['isbn']));
    }
    
    
    public function categories() {
        $books = Book::query();
        $books->groupBy('category');
        return response()->json($books->get(['category']));
    }
}
