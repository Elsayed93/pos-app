<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if (auth()->user()->hasRole('super_admin')) {

            // products 
            $productsCount = Product::count();

            // clients 
            $clientsCount = Client::count();

            // orders
            $ordersCount = Order::count();

            $total_orders_statistics = DB::table('orders')
                ->selectRaw('YEAR(created_at) AS year')
                ->selectRaw('MONTH(created_at) AS month')
                ->selectRaw('sum(total_price) AS total_price')
                ->groupBy('month')
                ->get();

            return view('dashboard.welcome', compact('productsCount', 'clientsCount', 'ordersCount', 'total_orders_statistics'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }
}
