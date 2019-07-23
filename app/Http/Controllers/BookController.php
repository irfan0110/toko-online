<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = \App\Book::with('categories')->paginate(5);

        return view('books.index',['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'title' => 'required|min:5|max:200',
            'description' => 'required|min:20|max:1000',
            'author' => 'required|min:3|max:100',
            'publisher' => 'required|min:3|max:200',
            'price' => 'required|digits_between:0, 10',
            'stock' => 'required|digits_between:0, 10',
            'cover' => 'required'
        ])->validate();

        $new_books = new \App\Book;
        $new_books->title = $request->get('title');
        $new_books->description = $request->get('description');
        $new_books->author = $request->get('author');
        $new_books->publisher = $request->get('publisher');
        $new_books->price = $request->get('price');
        $new_books->stock = $request->get('stock');
        $new_books->status = $request->get('save_action');

        $cover = $request->file('cover');
        if($cover){
            $cover_path = $cover->store('book-covers','public');

            $new_books->cover = $cover_path;
        }

        $new_books->slug = str_slug($request->get('title'));
        $new_books->created_by = \Auth::user()->id;
        
        $new_books->save();

        $new_books->categories()->attach($request->get('categories'));

        if($request->get('save_action') == 'PUBLISH'){
            return redirect()->route('books.index')->with('status','Book successfully saved and published');
        }else {
            return redirect()->route('books.index')->with('status','Book saved as draft');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
