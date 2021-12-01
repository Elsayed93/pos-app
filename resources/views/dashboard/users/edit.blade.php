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

            <h1>@lang('users.create')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.welcome') }}">
                        @lang('site.dashboard')
                    </a>
                </li>
                <li class="active"><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.users.index') }}">
                        @lang('users.users')
                    </a>
                </li>
                <li class="active"><i class="fa fa-dashboard"></i> @lang('users.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">@lang('users.edit')</h3>
                </div>


                @include('partials._errors')
                <!-- form start -->
                <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">


                        {{-- first name --}}
                        <div class="form-group">
                            <label for="firstName">@lang('users.first_name')</label>
                            <input type="text" class="form-control" id="firstName"
                                placeholder="@lang('users.enter first name')" name="first_name"
                                value="{{ $user->first_name }}">
                        </div>

                        {{-- last name --}}
                        <div class="form-group">
                            <label for="lastName">@lang('users.last_name')</label>
                            <input type="text" class="form-control" id="lastName"
                                placeholder="@lang('users.enter last name')" name="last_name"
                                value="{{ $user->last_name }}">
                        </div>

                        {{-- email --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('users.Email address')</label>
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                placeholder="@lang('users.Enter email')" name="email" value="{{ $user->email }}">
                        </div>

                        {{-- image --}}
                        <div class="form-group">
                            <label for="exampleImage">@lang('users.Image')</label>
                            <input type="file" class="form-control imgInp" id="exampleImage" name="image" accept="image/*">
                            <input type="hidden" name="image" value="{{ $user->image }}">
                        </div>

                        {{-- image preview --}}
                        <div class="form-group">
                            <img src="{{ asset('uploads/users_images/' . $user->image) }}" alt=""
                                class="img-thumbnail image-show" width="100">
                        </div>

                        {{-- permissions --}}
                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">

                                @php
                                    $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                    $maps = ['create', 'read', 'update', 'delete'];
                                @endphp

                                <ul class="nav nav-tabs">
                                    @foreach ($models as $index => $model)
                                        <li class="{{ $index == 0 ? 'active' : '' }}"><a href="#{{ $model }}"
                                                data-toggle="tab">@lang('site.' . $model)</a></li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">

                                    @foreach ($models as $index => $model)

                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}"
                                            id="{{ $model }}">

                                            @foreach ($maps as $map)
                                                <label>
                                                    {{-- users-create --}}
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $model . '-' . $map }}"
                                                        {{ $user->isAbleTo($model . '-' . $map) ? 'checked' : '' }}>
                                                    @lang('site.' . $map)
                                                </label>
                                            @endforeach

                                        </div>

                                    @endforeach

                                </div><!-- end of tab content -->

                            </div><!-- end of nav tabs -->

                        </div><!-- end of form-group -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
                        </div>
                    </div>
                </form>

                <!-- /.box-body -->
            </div>


        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
