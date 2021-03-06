<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->isAbleTo('orders-read')) {

            $orders = Order::whereHas('client', function (Builder  $query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })->with('client:id,name')->latest()->paginate(5);

            return view('dashboard.orders.index', compact('orders'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (auth()->user()->isAbleTo('orders-create')) {

            $client = Client::select('id')
                ->withCount('orders')
                ->findOrFail($request->client_id);

            $categories = Category::select('id')
                ->with('products:id,category_id,sale_price,stock')
                ->withCount('products')
                ->get();

            $orders = Order::select('id', 'created_at')
                ->with('products:id')
                ->latest()->paginate(5);

            return view('dashboard.orders.create', compact('client', 'categories', 'orders'));
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
    public function store(OrderRequest $request)
    {
        if (auth()->user()->isAbleTo('orders-create')) {

            //  ceate order 
            $order = Order::create([
                'order_code' => rand(1, 100),
                'client_id' => $request->client_id
            ]);

            // attach order products and update product stock
            $orderProducts = $this->attachOrderProducts($request, $order->id);

            if (!$orderProducts) {
                return redirect()->back()->with('error', __('site.Unknown Error'));
            }

            if ($order) {
                return redirect()->route('dashboard.orders.index')->with('success', __('site.added_successfully'));
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Order $order)
    {
        if (auth()->user()->isAbleTo('orders-update')) {

            $client = Client::select('id')
                ->withCount('orders')
                ->findOrFail($request->client);

            $categories = Category::select('id')
                ->with('products:id,category_id,sale_price,stock')
                ->withCount('products')
                ->get();

            $orders  = Order::select('id', 'created_at')
                ->with('products:id')
                ->latest()->paginate(5);

            return view('dashboard.orders.edit', compact('client', 'categories', 'order', 'orders'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {

        if (auth()->user()->isAbleTo('orders-update')) {

            $updateProductStorck = $this->updateProdStock($order);  

            $detachOrderProducts =  $this->detachOrderProducts($order); // return number of rows have been removed

            if ($detachOrderProducts <= 0) {
                return redirect()->back()->with('error', __('site.Unknown Error'));
            }

            $orderProducts = $this->attachOrderProducts($request, $order->id);

            if (!$orderProducts || !$updateProductStorck) {
                return redirect()->back()->with('error', __('site.Unknown Error'));
            }

            //  ceate order 
            $order->update([
                'order_code' => $request->order_code,
            ]);

            if ($order) {
                return redirect()->route('dashboard.orders.index')->with('success', __('site.updated_successfully'));
            } else {
                return redirect()->back()->with('error', __('site.updated_failed'));
            }
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {

        if (auth()->user()->isAbleTo('orders-delete')) {

            // update product stock
            $prodStock = $this->updateProdStock($order);

            if (!$prodStock) {
                return redirect()->back()->with('error', __('site.Unknown Error'));
            }

            // delete order and detach its products automatically by DB
            $order->findOrFail($order->id)->delete();

            if ($order) {
                return redirect()->route('dashboard.orders.index')->with('success', __('site.deleted_successfully'));
            } else {
                return redirect()->back()->with('error', __('site.deleted_failed'));
            }
            // 
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    // when create order >> attach products to this order in order_product table
    private function attachOrderProducts($request, $orderId)
    {

        foreach ($request->products as $product_id => $value) {

            $product = Product::findOrFail($product_id);

            if ($product->stock -  $value['quantity'] < 0) {
                Order::findOrFail($orderId)->delete();
                return redirect()->back()->with('error', __('orders.out of stock'));
            }

            // store in order_product
            $order_product = DB::table('order_product')->insert([
                'order_id' => $orderId,
                'product_id' => $product_id,
                'quantity' => $value['quantity'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            // update product stock
            $product->update([
                'stock' => $product->stock -  $value['quantity'], // 
            ]);
        }

        if ($order_product && $product) {
            return true;
        }
    }


    // update product stock when delete order
    private function updateProdStock($order)
    {
        foreach ($order->products as $product) {

            // get product by $product->id
            $prod = Product::select('id')->findOrFail($product->id);

            // update product stock
            $prod->update([
                'stock' => $product->stock + $product->pivot->quantity,
            ]);
        }

        return $prod ? true : false;
    }

    // get order products
    public function getOrderProducts(Order $order)
    {
        $orderProducts = $order->products;
        $orderTotalPrice = 0;

        foreach ($orderProducts as $key => $product) {
            $prodPrice = $product->sale_price;
            $prodQuantity = $product->pivot->quantity;

            $subTotPrice =  $prodPrice * $prodQuantity;
            $orderTotalPrice += $subTotPrice;
        }

        return view('dashboard.orders._products', compact('orderTotalPrice', 'orderProducts'));
    }

    private function detachOrderProducts($order)
    {
        return $order->products()->detach();
    }
}
