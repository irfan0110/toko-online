<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = \App\Category::paginate(5);

        $filter = $request->get('name');

        if($filter){
            $categories = \App\Category::where('name', 'LIKE', "%$filter%")->paginate(5);
        }
        return view('categories.index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        $validation = \Validator::make($request->all(), [
            'name' => 'required|min:5|max:100',
            'image' => 'required'
        ])->validate();

        $new_category = new \App\Category;
        $new_category->name = $request->get('name');

        if($request->file('image')){
            $image_path = $request->file('image')->store('category_image','public');

            $new_category->image = $image_path;
        }

        $new_category->created_by = \Auth::user()->id;
        $new_category->slug = str_slug($name,'-');

        $new_category->save();

        return redirect()->route('categories.index')->with('status','Category successfully created');
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
