<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            return $query->whereTranslationLike('name', '%' . $request->search . '%');
        })->latest()->paginate(5);


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

        $rules = [];

        foreach (config('translatable.locales') as  $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('category_translations', 'name')->where(function ($q) use ($locale) {
                return $q->where('locale', $locale);
            })]];
        }

        $request->validate($rules);

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
        $rules = [];

        foreach (config('translatable.locales') as  $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('category_translations', 'name')
                ->ignore($category->id, 'category_id')
                ->where(function ($q) use ($locale) {
                    return $q->where('locale', $locale);
                })]];
        }

        $request->validate($rules);


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

    // get all categories
    public function getAllCategories()
    {
        $all_categories = Category::get();

        return $all_categories;
    }


    public function getProductCategory(Request $request)
    {
        $productCategory = Category::findOrFail($request->category_id);
        return $productCategory;
    }
}
