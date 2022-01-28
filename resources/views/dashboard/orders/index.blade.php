@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.orders')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.welcome') }}">
                        @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.orders')</li>
            </ol>
        </section>

        <section class="content">

            <div class="container-fluid">

                <div class="box box-solid">

                    <div class="box-header with-border">
                        <h3 class="box-title mb-3">
                            @lang('site.orders')
                        </h3>
                        <small class="totalNumbers">{{ $orders->total() }}</small>


                        <form action="{{ route('dashboard.orders.index') }}" method="GET" style="margin-top:20px;">
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

                                    {{-- @if (auth()->user()->isAbleTo('orders-create'))
                                     
                                        <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary">
                                            <i class="fa fa-plus"></i>
                                            @lang('site.create')
                                        </a>

                                    @else
                                        <a href="#" class="btn btn-primary" aria-disabled="true" disabled>
                                            <i class="fa fa-plus"></i>
                                            @lang('site.create')
                                        </a>
                                    @endif --}}

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
                                        <th>@lang('orders.code')</th>
                                        <th>@lang('orders.client')</th>
                                        <th>@lang('orders.details')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orders->count() > 0)
                                        @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{{ $order->client->name }}</td>
                                                <td>
                                                    <a href="">details</a>
                                                </td>

                                                <td>
                                                    @if (auth()->user()->isAbleTo('orders-update'))
                                                        <a href="{{ route('dashboard.orders.edit', $order->id) }}"
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
                                                    @if (auth()->user()->isAbleTo('orders-delete'))

                                                        <form
                                                            action="{{ route('dashboard.orders.destroy', $order->id) }}"
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
                                        <td colspan="4" class="nodata">@lang('site.There is no orders.')</td>
                                    @endif

                                </tbody>
                            </table>

                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
