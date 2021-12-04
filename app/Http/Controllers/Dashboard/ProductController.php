<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
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
        $products = Product::latest()->paginate(10);

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            'stock' => 'required|integer',
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
