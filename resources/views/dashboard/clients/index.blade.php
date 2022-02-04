@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.welcome') }}">
                        @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.clients')</li>
            </ol>
        </section>

        <section class="content">

            <div class="container-fluid">

                <div class="box box-solid">

                    <div class="box-header with-border">
                        <h3 class="box-title mb-3">
                            @lang('site.clients')
                        </h3>
                        <small class="totalNumbers">{{ $clients->total() }}</small>


                        <form action="{{ route('dashboard.clients.index') }}" method="GET" style="margin-top:20px;">
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request()->search }}" placeholder="@lang('site.search')">

                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                        @lang('site.search')
                                    </button>

                                    @if (auth()->user()->isAbleTo('clients-create'))
                                        {{-- Create client --}}
                                        <a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary">
                                            <i class="fa fa-plus"></i>
                                            @lang('site.create')
                                        </a>

                                    @else
                                        <a href="#" class="btn btn-primary" aria-disabled="true" disabled>
                                            <i class="fa fa-plus"></i>
                                            @lang('site.create')
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="box-body border-radius-none" style="margin-top:20px;">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.phone')</th>
                                        <th>@lang('site.address')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    @if ($clients->count() > 0)
                                        @foreach ($clients as $index => $client)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ implode($client->phone, ' - ') }}</td>
                                                <td>
                                                    @if (auth()->user()->isAbleTo('orders-create'))
                                                        <a href="{{ route('dashboard.orders.create', ['client_id' => $client->id]) }}"
                                                            class="btn btn-primary">
                                                            @lang('orders.Add Order')
                                                        </a>
                                                    @else
                                                        <a href="#" class="btn btn-primary" disabled> @lang('orders.Add
                                                            Order')</a>
                                                    @endif

                                                </td>
                                                <td>{{ $client->address }}</td>

                                                <td>
                                                    @if (auth()->user()->isAbleTo('clients-update'))
                                                        <a href="{{ route('dashboard.clients.edit', $client->id) }}"
                                                            class="btn btn-warning btn-sm" title="@lang('site.edit')">
                                                            @lang('site.edit')
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                    @else

                                                        <a href="#" class="btn btn-warning btn-sm" disabled
                                                            title="@lang('site.edit')">
                                                            @lang('site.edit')
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                    @endif
                                                    @if (auth()->user()->isAbleTo('clients-delete'))

                                                        <form
                                                            action="{{ route('dashboard.clients.destroy', $client->id) }}"
                                                            method="post" id="deleteForm" style="display: inline-block;">
                                                            @method('DELETE')
                                                            @csrf

                                                            <button type="submit" class="btn btn-danger btn-sm delete"
                                                                title="@lang('site.delete')">
                                                                @lang('site.delete')
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @else

                                                        <a href="#" class="btn btn-danger btn-sm" disabled
                                                            title="@lang('site.delete')">
                                                            @lang('site.delete')
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="4" class="nodata">@lang('site.There is no clients.')</td>
                                    @endif

                                </tbody>
                            </table>

                            {{ $clients->appends(request()->query())->links() }}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
