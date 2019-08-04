<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';

        if($status){
            $books = \App\Book::with('categories')
                                ->where('title',"LIKE","%$keyword%")
                                ->where('status',strtoupper($status))
                                ->orWhere('author',"LIKE","%$keyword%")
                                ->where('status', strtoupper($status))
                                ->paginate(5);
        }else {
            $books = \App\Book::with('categories')
                                ->where('title',"LIKE","%$keyword%")
                                ->orWhere('author',"LIKE","%$keyword%")
                                ->paginate(5);
        }
        
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
        $book = \App\Book::findOrFail($id);
        return view('books.edit',['book' => $book]);
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
        \Validator::make($request->all(), [
            'title' => 'required|min:5|max:200',
            'description' => 'required|min:20|max:1000',
            'author' => 'required|min:3|max:100',
            'publisher' => 'required|min:3|max:200',
            'price' => 'required|digits_between:0, 10',
            'stock' => 'required|digits_between:0, 10',
        ]);

        $book = \App\Book::findOrFail($id);

        $book->title = $request->get('title');
        $book->slug = $request->get('slug');
        $book->description = $request->get('description');
        $book->author = $request->get('author');
        $book->publisher = $request->get('publisher');
        $book->stock = $request->get('stock');
        $book->price - $request->get('price');

        $new_cover = $request->file('cover');

        if($new_cover){
            if($book->cover && file_exists(storage_path('app/public/'.$book->cover))){
                \Storage::delete('public/'.$book->cover);
            }

            $new_cover_path = $new_cover->store('book-covers','public');
            $book->cover = $new_cover_path;
        }

        $book->updated_by = \Auth::user()->id;
        $book->status = $request->get('status');

        $book->save();
        $book->categories()->sync($request->get('categories'));

        return redirect()->route('books.index')->with('status','Book successfully updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = \App\Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('status','Book moved to trash');
    }

    public function trash(Request $request)
    {

        $keyword = $request->get('keyword');
        if($keyword){
            $books = \App\Book::onlyTrashed()
                                ->where('title','LIKE',"%$keyword%")
                                ->orWhere('author','LIKE',"%$keyword%")
                                ->paginate(5);
        }else {
            $books = \App\Book::onlyTrashed()->paginate(5);
        }
        

        return view('books.trash',['books' => $books]);
    }

    public function restore($id)
    {
        $book = \App\Book::withTrashed()->findOrFail($id);

        if($book->trashed()){
            $book->restore();
            return redirect()->route('books.index')->with('status','Book successfully restored');
        }else {
            return redirect()->route('books.index')->with('status','Book is not in trash');
        }
    }

    public function deletePermanent($id)
    {
        $book = \App\Book::withTrashed()->findOrFail($id);

        if(!$book->trashed()){
            return redirect()->route('books.trash')->with('status','Book is not in trash!');
        }else {
            $book->categories()->detach();
            $book->forceDelete();

            return redirect()->route('books.index')->with('status','Book permanently deleted!');
        }
    }
}
