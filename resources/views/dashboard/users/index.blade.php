@extends('layouts.dashboard.app')

@section('content')
    {{-- {{dd($users)}} --}}
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('users.users')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.welcome') }}">
                        @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-dashboard"></i> @lang('users.users')</li>
            </ol>
        </section>

        <section class="content">




            <div class="container-fluid">




                <div class="box box-solid">

                    <div class="box-header with-border">
                        <h3 class="box-title mb-3"> @lang('users.users') </h3>


                        <form action="" style="margin-top:20px;">
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="" id=""
                                        placeholder="@lang('site.search')">

                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                        @lang('site.search')
                                    </button>
                                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>
                                        @lang('users.create')
                                    </a>
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
                                        <th>@lang('users.name')</th>
                                        <th>@lang('users.email')</th>
                                        <th>@lang('users.action')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->count() > 0)
                                        @foreach ($users as $index => $user)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm" title="Edit">Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm" title="Delete">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="4">There is no users.</td>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
