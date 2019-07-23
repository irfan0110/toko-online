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
        $category = \App\Category::findOrFail($id);
        return view('categories.detail',['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = \App\Category::findOrFail($id);
        return view('categories.edit', ['categories' => $categories]);
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
        $categories = \App\Category::findOrFail($id);

        
        $validation = \Validator::make($request->all(), [
            'name' => 'required|min:5|max:100',
            'slug' => 'required',
        ])->validate();

        $name = $request->get('name');
        $slug = $request->get('slug');
        
        $categories->name = $name;
        $categories->slug = $slug;
        
        if($request->file('image')){
            if($categories->image && file_exists(storage_path('app/public/'.$categories->image))){
                \Storage::delete('public/'.$categories->image);

                $new_image = $request->file('image')->store('category_image','public');

                $categories->image = $new_image;
            }
        }

        $categories->updated_by = \Auth::user()->id;
        $categories->slug = str_slug($name);
        
        $categories->save();
        
        return redirect()->route('categories.index')->with('status','Category successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = \App\Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('status','Category successfully move to trash');
    }

    public function trash()
    {
        $deleted_category = \App\Category::onlyTrashed()->paginate(5);
        return view('categories.trash',['categories' => $deleted_category]);
    }

    public function restore($id) 
    {
        $category = \App\Category::withTrashed()->findOrFail($id);

        if($category->trashed()){
            $category->restore();
        }else {
            return redirect()->route('categories.index')->with('status','Category is not in trashed');
        }

        return redirect()->route('categories.index')->with('status','Category successfully restored');
    }

    public function deletePermanent($id)
    {
        $category = \App\Category::withTrashed()->findOrFail($id);

        if(!$category->trashed()){
            return redirect()->route('categories.index')->with('status','Can not delete permanent active category');
        }else {
            $category->forceDelete();
            return redirect()->route('categories.index')->with('status','Category permanently deleted');
        }
    }

    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');

        $categories = \App\Category::where('name', 'LIKE', "%$keyword%")->get();

        return $categories;
    }
}
