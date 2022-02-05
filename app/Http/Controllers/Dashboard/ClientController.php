<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (auth()->user()->isAbleTo('clients-read')) {

            $clients = Client::when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%');
            })->latest()->paginate(5);

            return view('dashboard.clients.index', compact('clients'));
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
        if (auth()->user()->isAbleTo('clients-create')) {

            return view('dashboard.clients.create');
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
        if (auth()->user()->isAbleTo('clients-create')) {
            $request->validate([
                'name' => 'required',
                'phone.0' => ['required', 'regex:/(01)[0-9]{9}/'],
                'phone.1' => ['nullable', 'regex:/(01)[0-9]{9}/'],
                'address' => 'required',
            ]);

            $data = $request->all();
            $data['phone'] = array_filter($request->phone);

            // create a new client
            $client =  Client::create($data);

            if ($client) {
                return redirect()->route('dashboard.clients.index')->with('success', __('site.added_successfully'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {

        if (auth()->user()->isAbleTo('clients-update')) {
            return view('dashboard.clients.edit', compact('client'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        if (auth()->user()->isAbleTo('clients-update')) {
            $request->validate([
                'name' => 'required',
                'phone.0' => ['required', 'regex:/(01)[0-9]{9}/'],
                'phone.1' => ['nullable', 'regex:/(01)[0-9]{9}/'],
                'address' => 'required',
            ]);

            $data = $request->all();
            $data['phone'] = array_filter($request->phone);

            // update client
            $client->update($data);


            if ($client) {
                return redirect()->route('dashboard.clients.index')->with('success', __('site.updated_successfully'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if (auth()->user()->isAbleTo('clients-delete')) {
            // $clientOrders = $client->withCount('orders')->first();
            $client->delete();
            
            return redirect()->route('dashboard.clients.index')->with('success', __('site.deleted_successfully'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }
}
