@extends('layouts.dashboard.app')

@push('head')
    <style>
        .box.box-solid {
            padding: 20px;
            border-radius: 5px;
        }

    </style>
@endpush

@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('categories.edit')</h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.welcome') }}">
                        @lang('site.dashboard')
                    </a>
                </li>
                <li class="active"><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.categories.index') }}">
                        @lang('categories.categories')
                    </a>
                </li>
                <li class="active"><i class="fa fa-dashboard"></i> @lang('categories.edit')</li>
            </ol>

        </section>

        <section class="content">

            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">@lang('categories.edit')</h3>
                </div>

                @include('partials._errors')
                <!-- form start -->
                <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        {{-- name --}}
                        <div class="form-group">
                            <label for="name">@lang('site.name')</label>
                            <input type="text" class="form-control" id="name" placeholder="@lang('site.enter name')"
                                name="name" value="{{ $category->name }}">
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('site.Submit')</button>
                        </div>
                    </div>

                </form>
            </div> <!-- /.box-body -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
