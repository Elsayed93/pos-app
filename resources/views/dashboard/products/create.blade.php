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
            <h1>@lang('products.create')</h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.welcome') }}">
                        @lang('site.dashboard')
                    </a>
                </li>

                <li class="active"><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.products.index') }}">
                        @lang('products.products')
                    </a>
                </li>
                <li class="active"><i class="fa fa-dashboard"></i> @lang('products.create')</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">@lang('products.create')</h3>
                </div>

                @include('partials._errors')
                <!-- form start -->
                <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        {{-- categories --}}
                        <div class="form-group">
                            <label for="categories">@lang('site.categories')</label>
                            <select name="category_id" id="categories" class="form-control"
                                data-oldcategory="{{ old() ? old('category_id') : '' }}">
                                <option value="">@lang('site.Select Category')</option>
                            </select>
                        </div>

                        @foreach (config('translatable.locales') as $locale)
                            {{-- name --}}
                            <div class="form-group">
                                <label for="{{ $locale }}_name">@lang('site.'.$locale.'_name')</label>
                                <input type="text" class="form-control" id="{{ $locale }}_name"
                                    placeholder="@lang('site.enter name')" name="{{ $locale }}[name]"
                                    value="{{ old($locale . '.name') }}">
                            </div>

                            {{-- description --}}
                            <div class="form-group">
                                <label for="{{ $locale }}_description">@lang('site.'.$locale.'_description')</label>
                                <textarea class="form-control ckeditor" id="{{ $locale }}_description"
                                    placeholder="@lang('site.enter description')"
                                    name="{{ $locale }}[description]">{{ old($locale . '.description') }}</textarea>
                            </div>
                        @endforeach

                        {{-- image --}}
                        <div class="form-group">
                            <label for="exampleImage">@lang('site.Image')</label>
                            <input type="file" class="form-control imgInp" id="exampleImage" name="image" accept="image/*">
                        </div>

                        {{-- image preview --}}
                        <div class="form-group">
                            <img src="" alt="" class="img-thumbnail image-show" width="100" style="display: none;">
                        </div>

                        {{-- purchase_price --}}
                        <div class="form-group">
                            <label for="purchase_price">@lang('site.purchase_price')</label>
                            <input type="number" step="0.01" class="form-control" id="purchase_price"
                                placeholder="@lang('site.enter purchase price')" name="purchase_price"
                                value="{{ old('purchase_price') }}">
                        </div>

                        {{-- sale_price --}}
                        <div class="form-group">
                            <label for="sale_price">@lang('site.sale_price')</label>
                            <input type="number" step="0.01" class="form-control" id="sale_price"
                                placeholder="@lang('site.enter sale price')" name="sale_price"
                                value="{{ old('sale_price') }}">
                        </div>


                        {{-- stock --}}
                        <div class="form-group">
                            <label for="stock">@lang('site.stock')</label>
                            <input type="number" step="0.01" class="form-control" id="stock"
                                placeholder="@lang('site.enter stock')" name="stock" value="{{ old('stock') }}">
                        </div>


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

@push('scripts')
    {{-- get all categories --}}
    <script>
        $.ajax({
            url: "{{ route('dashboard.get.all.categories') }}",

            success: function(data) {
                let old_category_id = $('#categories').data('oldcategory'); // in case != '' >>> =1 : selected

                $.each(data, function(i, item) {

                    if (old_category_id == item.id) {
                        $('#categories').append($('<option>').val(item.id).text(item.name).attr(
                            'selected', 'selected'));
                    } else {
                        $('#categories').append($('<option>').val(item.id).text(item.name));

                    }

                });
            }
        });


        // $('#categories').on('change', function() {
        //     console.log($(this).find('option:selected').val());
        //     console.log($(this).val());
        //     if($(this).find('option:selected')){

        //     }
        // });
    </script>
@endpush
