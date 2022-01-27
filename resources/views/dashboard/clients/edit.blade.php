@extends('layouts.dashboard.app')

@push('head')
    <style>
        .box.box-solid {
            padding: 20px;
            border-radius: 5px;
        }

        .tab-pane label {
            margin-right: 10px;
            margin-left: 10px;
        }

    </style>
@endpush

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('clients.create')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.welcome') }}">
                        @lang('site.dashboard')
                    </a>
                </li>
                <li class="active"><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.clients.index') }}">
                        @lang('clients.clients')
                    </a>
                </li>
                <li class="active"><i class="fa fa-dashboard"></i> @lang('clients.create')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">@lang('clients.create')</h3>
                </div>


                @include('partials._errors')
                <!-- form start -->
                <form action="{{ route('dashboard.clients.update', $client->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        {{-- name --}}
                        <div class="form-group">
                            <label for="name">@lang('site.name') <span class="required-field">*</span></label>
                            <input type="text" class="form-control" id="name" placeholder="@lang('site.enter name')"
                                name="name" value="{{ $client->name }}">
                        </div>

                        {{-- phone --}}
                        @for ($i = 1; $i < 3; $i++)
                            <div class="form-group">
                                <label for="{{ 'phone' . $i }}">@lang('site.phone'.$i) <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="{{ 'phone' . $i }}"
                                    placeholder="@lang('site.enter phone'.$i)" name="phone[]"
                                    value="{{ $client->phone[$i - 1] }}">
                            </div>
                        @endfor


                        {{-- address --}}
                        <div class="form-group">
                            <label for="address">@lang('site.address') <span class="required-field">*</span></label>

                            <textarea name="address" id="address" rows="5" class="form-control"
                                placeholder="@lang('site.enter address')">{{ $client->address }}</textarea>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('site.update')</button>
                        </div>
                    </div>
                </form>

                <!-- /.box-body -->
            </div>


        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
