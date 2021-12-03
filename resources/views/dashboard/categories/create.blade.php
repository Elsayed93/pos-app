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

            <h1>@lang('categories.create')</h1>

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
                <li class="active"><i class="fa fa-dashboard"></i> @lang('categories.create')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">@lang('categories.create')</h3>
                </div>


                @include('partials._errors')
                <!-- form start -->
                <form action="{{ route('dashboard.categories.store') }}" method="POST">
                    @csrf
                    <div class="card-body">


                        @foreach (config('translatable.locales') as $locale)
                            {{-- name --}}
                            <div class="form-group">
                                <label for="{{ $locale }}_name">@lang('site.'.$locale.'_name')</label>
                                <input type="text" class="form-control" id="{{ $locale }}_name"
                                    placeholder="@lang('site.enter name')" name="{{ $locale }}[name]"
                                    value="{{ old($locale . '.name') }}">
                            </div>
                        @endforeach

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('site.Submit')</button>
                        </div>
                    </div>
                </form>

                <!-- /.box-body -->
            </div>


        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
