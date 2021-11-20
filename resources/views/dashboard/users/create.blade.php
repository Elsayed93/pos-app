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
                <li class="active"><i class="fa fa-dashboard"></i> @lang('users.create')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">@lang('users.create')</h3>
                </div>


                @include('partials._errors')
                <!-- form start -->
                <form action="{{ route('dashboard.users.store') }}" method="POST">
                    @csrf
                    <div class="card-body">


                        {{-- first name --}}
                        <div class="form-group">
                            <label for="firstName">@lang('users.first_name')</label>
                            <input type="text" class="form-control" id="firstName"
                                placeholder="@lang('users.enter first name')" name="first_name"
                                value="{{ old('first_name') }}">
                        </div>

                        {{-- last name --}}
                        <div class="form-group">
                            <label for="lastName">@lang('users.last_name')</label>
                            <input type="text" class="form-control" id="lastName"
                                placeholder="@lang('users.enter last name')" name="last_name"
                                value="{{ old('last_name') }}">
                        </div>

                        {{-- email --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('users.Email address')</label>
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                placeholder="@lang('users.Enter email')" name="email" value="{{ old('email') }}">
                        </div>
                        {{-- password --}}
                        <div class="form-group">
                            <label for="exampleInputPassword1">@lang('users.Password')</label>
                            <input type="password" class="form-control" id="exampleInputPassword1"
                                placeholder="@lang('users.Password')" name="password" value="{{ old('password') }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPasswordConfirmation">@lang('users.Password Confirmation')</label>
                            <input type="password" class="form-control" id="exampleInputPasswordConfirmation"
                                placeholder="@lang('users.Password Confirmation')" name="password_confirmation"
                                value="{{ old('password_confirmation') }}">
                        </div>
                        {{-- <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div> --}}

                        {{-- <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                    </div> --}}

                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

                <!-- /.box-body -->
            </div>


        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
