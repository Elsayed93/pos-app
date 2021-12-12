@extends('layouts.dashboard.app')

@push('head')
    <style>
        #nocategories {
            text-align: center;
            padding-top: 25px;
            font-size: 20px;
        }


        #totlacategories {
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

            <h1>@lang('categories.categories')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.welcome') }}">
                        @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-dashboard"></i> @lang('categories.categories')</li>
            </ol>
        </section>

        <section class="content">

            <div class="container-fluid">

                <div class="box box-solid">

                    <div class="box-header with-border">
                        <h3 class="box-title mb-3">
                            @lang('categories.categories')
                        </h3>

                        <small id="totlacategories">{{ $categories->total() }}</small>


                        <form action="{{ route('dashboard.categories.index') }}" method="GET" style="margin-top:20px;">
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

                                    @if (auth()->user()->isAbleTo('categories-create'))
                                        {{-- Create category --}}
                                        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">
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
                                        <th>@lang('site.Products Number')</th>
                                        <th>@lang('site.Related Products')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($categories->count() > 0)
                                        @foreach ($categories as $index => $category)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->products()->count() }}</td>
                                                <td>
                                                    <a href="{{ route('dashboard.products.index', ['category_id' => $category->id]) }}"
                                                        class="btn btn-info btn-sm">
                                                        @lang('site.Related Products')
                                                    </a>
                                                </td>
                                                <td>
                                                    @if (auth()->user()->isAbleTo('categories-update'))
                                                        <a href="{{ route('dashboard.categories.edit', $category->id) }}"
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
                                                    @if (auth()->user()->isAbleTo('categories-delete'))

                                                        <form
                                                            action="{{ route('dashboard.categories.destroy', $category->id) }}"
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
                                        <td colspan="4" id="nocategories">@lang('categories.There is no categories.')</td>
                                    @endif

                                </tbody>
                            </table>

                            {{ $categories->appends(request()->query())->links() }}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
