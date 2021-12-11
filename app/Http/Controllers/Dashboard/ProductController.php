<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->isAbleTo('products-read')) {
            $products = Product::latest()->paginate(10);
            return view('dashboard.products.index', compact('products'));
            //
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (auth()->user()->isAbleTo('products-create')) {
            return view('dashboard.products.create');
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (auth()->user()->isAbleTo('products-create')) {

            // validation
            $rules = [];

            foreach (config('translatable.locales') as  $locale) {

                $rules += [$locale . '.name' => ['required', Rule::unique('product_translations', 'name')->where(function ($q) use ($locale) {
                    return $q->where('locale', $locale);
                })]];

                $rules += [$locale . '.description' => ['required', Rule::unique('product_translations', 'description')->where(function ($q) use ($locale) {
                    return $q->where('locale', $locale);
                })]];
            }

            $rules += [
                'category_id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'purchase_price' => 'required|numeric|gt:0',
                'sale_price' => 'required|numeric|gt:0',
                'stock' => 'required|integer|gt:0',
            ];

            $request->validate($rules);

            $request_data = $request->except(['image']);

            // handle image
            if ($request->has('image')) {
                $img = Image::make($request->image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/products/') . $request->image->hashName());
            }

            if ($request->image != null) {
                $request_data['image'] = $request->image->hashName();
            } else {

                $request_data['image'] = 'default.jpg';
            }

            // create
            $product = Product::create($request_data);


            if ($product) {
                return redirect()->route('dashboard.products.index')->with('success', __('site.added_successfully'));
            } else {
                return redirect()->back()->with('error', __('site.added_failed'));
            }
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (auth()->user()->isAbleTo('products-update')) {
            return view('dashboard.products.edit', compact('product'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        if (auth()->user()->isAbleTo('products-update')) {

            // validation
            $rules = [];

            foreach (config('translatable.locales') as  $locale) {

                $rules += [$locale . '.name' => ['required', Rule::unique('product_translations', 'name')
                    ->ignore($product->id, 'product_id')
                    ->where(function ($q) use ($locale) {
                        return $q->where('locale', $locale);
                    })]];

                $rules += [$locale . '.description' => ['required', Rule::unique('product_translations', 'description')
                    ->ignore($product->id, 'product_id')
                    ->where(function ($q) use ($locale) {
                        return $q->where('locale', $locale);
                    })]];
            }

            $rules += [
                'category_id' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'purchase_price' => 'required|numeric|gt:0',
                'sale_price' => 'required|numeric|gt:0',
                'stock' => 'required|integer|gt:0',
            ];

            $request->validate($rules);

            $request_data = $request->except(['image']);

            // handle image
            if ($request->has('image')) {
                $img = Image::make($request->image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/products/') . $request->image->hashName());
            }

            if ($request->image != null) {
                $request_data['image'] = $request->image->hashName();
            } else {

                $request_data['image'] = 'default.jpg';
            }

            // update
            $product->update($request_data);


            if ($product) {
                return redirect()->route('dashboard.products.index')->with('success', __('site.added_successfully'));
            } else {
                return redirect()->back()->with('error', __('site.added_failed'));
            }
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (auth()->user()->isAbleTo('products-delete')) {
            if ($product->image != 'default.jpg') {
                Storage::disk('public_uploads')->delete('products/' . $product->image);
            }
            $product->delete();
            return redirect()->route('dashboard.products.index')->with('success', __('site.deleted_successfully'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }
}
