@extends('layouts.dashboard.app')

@push('head')
    <style>
        #noproducts {
            text-align: center;
            padding-top: 25px;
            font-size: 20px;
        }


        #totlaproducts {
            background-color: #3c8dbc;
            color: white;
            padding: 1px 5px;
            border-radius: 2px;
            font-size: 13px;
        }

    </style>
@endpush


@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('products.products')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.welcome') }}">
                        @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-dashboard"></i> @lang('products.products')</li>
            </ol>
        </section>

        <section class="content">

            <div class="container-fluid">

                <div class="box box-solid">

                    <div class="box-header with-border">
                        <h3 class="box-title mb-3">
                            @lang('products.products')
                        </h3>

                        <small id="totlaproducts">{{ $products->total() }}</small>


                        <form action="{{ route('dashboard.products.index') }}" method="GET" style="margin-top:20px;">
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

                                    @if (auth()->user()->isAbleTo('products-create'))
                                        {{-- Create product --}}
                                        <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
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

                                {{-- categories --}}
                                <div class="col-md-4">
                                    <select name="category_id" id="categories" class="form-control">
                                        <option value="">@lang('site.Select Category')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                        <th>@lang('site.description')</th>
                                        <th>@lang('site.image')</th>
                                        <th>@lang('site.purchase_price')</th>
                                        <th>@lang('site.sale_price')</th>
                                        <th>@lang('site.profit') %</th>
                                        <th>@lang('site.stock')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($products->count() > 0)
                                        @foreach ($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{!! $product->description !!}</td>
                                                <td>
                                                    <img src="{{ asset('uploads/products/' . $product->image) }}" alt=""
                                                        class="img-thumbnail" width="80">
                                                </td>
                                                <td>{{ $product->purchase_price }}</td>
                                                <td>{{ $product->sale_price }}</td>
                                                <td>{{ $product->profit_percentage }} %</td>
                                                <td>{{ $product->stock }}</td>
                                                <td>
                                                    @if (auth()->user()->isAbleTo('products-update'))
                                                        <a href="{{ route('dashboard.products.edit', $product->id) }}"
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
                                                    @if (auth()->user()->isAbleTo('products-delete'))

                                                        <form
                                                            action="{{ route('dashboard.products.destroy', $product->id) }}"
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
                                        <td colspan="8" id="noproducts">@lang('products.There is no products.')</td>
                                    @endif

                                </tbody>
                            </table>

                            {{ $products->appends(request()->query())->links() }}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
