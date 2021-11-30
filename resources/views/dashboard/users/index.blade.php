@extends('layouts.dashboard.app')

@push('head')
    <style>
        #noUsers {
            text-align: center;
            padding-top: 25px;
            font-size: 20px;
        }


        #totlaUsers {
            background-color: #3c8dbc;
            color: white;
            padding: 1px 5px;
            border-radius: 2px;
            font-size: 13px;
        }

    </style>
@endpush


@section('content')
    {{-- {{dd(get_defined_vars())}} --}}
    {{-- {{dd($users[0]->image)}} --}}

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
                        <h3 class="box-title mb-3">
                            @lang('users.users')
                        </h3>
                        <small id="totlaUsers">{{ $users->total() }}</small>


                        <form action="{{ route('dashboard.users.index') }}" method="GET" style="margin-top:20px;">
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

                                    @if (auth()->user()->isAbleTo('users-create'))
                                        {{-- Create User --}}
                                        <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">
                                            <i class="fa fa-plus"></i>
                                            @lang('users.create')
                                        </a>

                                    @else
                                        <a href="#" class="btn btn-primary" aria-disabled="true" disabled>
                                            <i class="fa fa-plus"></i>
                                            @lang('users.create')
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="box-body border-radius-none" style="margin-top:20px;">
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- {{ dd(public_path('uploads/images/users_images/' . $users[0]->image)) }} --}}
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>@lang('users.name')</th>
                                        <th>@lang('users.email')</th>
                                        <th>@lang('users.Image')</th>
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
                                                    <img src="{{ asset('uploads/users_images/' . $user->image) }}"
                                                        alt="user image" width="80" class="img-thumbnail">

                                                </td>
                                                <td>
                                                    @if (auth()->user()->isAbleTo('users-update'))
                                                        <a href="{{ route('dashboard.users.edit', $user->id) }}"
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
                                                    @if (auth()->user()->isAbleTo('users-delete'))

                                                        <form action="{{ route('dashboard.users.destroy', $user->id) }}"
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
                                        <td colspan="4" id="noUsers">@lang('users.There is no users.')</td>
                                    @endif

                                </tbody>
                            </table>

                            {{ $users->appends(request()->query())->links() }}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
