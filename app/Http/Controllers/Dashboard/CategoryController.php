<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $categories = Category::when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%');
        }, function ($query) {
            return $query->paginate(5);
        });


        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:categories,name',
            ]
        );

        $category = Category::create($request->all());


        if ($category) {
            return redirect()->route('dashboard.categories.index')->with('success', __('site.added_successfully'));
        } else {
            return redirect()->back()->with('error', __('site.added_failed'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate(
            [
                'name' => 'required|unique:categories,name,' . $category->id,
            ]
        );

        $category->update($request->all());


        if ($category) {
            return redirect()->route('dashboard.categories.index')->with('success', __('site.updated_successfully'));
        } else {
            return redirect()->back()->with('error', __('site.updated_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();


        if ($category) {
            return redirect()->route('dashboard.categories.index')->with('success', __('site.deleted_successfully'));
        } else {
            return redirect()->back()->with('error', __('site.deleted_failed'));
        }
    }
}
