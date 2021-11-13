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

                    <div class="box-header">
                        <h3 class="box-title">
                            <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">
                                {{ __('users.create') }}
                            </a>
                        </h3>
                    </div>
                    <div class="box-body border-radius-none">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
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
                                                <td>{{ $user->name }}</td>
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
