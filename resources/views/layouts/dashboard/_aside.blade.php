<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('dashboard_files/img/user2-160x160.jpg') }}" class="img-circle"
                    alt="User Image">
            </div>
            <div class="pull-left info">
                {{-- <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p> --}}
                <p>{{ auth()->user()->getFullNameAttribute() }}</p>

                {{-- getFullNameAttribute --}}
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            {{-- dashboard --}}
            <li>
                <a href="{{ route('dashboard.welcome') }}">
                    <i class="fa fa-th"></i>
                    <span>@lang('site.dashboard')</span>
                </a>
            </li>

            {{-- clients --}}
            @if (auth()->user()->isAbleTo('clients-read'))
                <li>
                    <a href="{{ route('dashboard.clients.index') }}">
                        <i class="fa fa-th"></i>
                        <span>@lang('site.clients')</span>
                    </a>
                </li>
            @endif


            {{-- categories --}}
            @if (auth()->user()->isAbleTo('categories-read'))
                <li>
                    <a href="{{ route('dashboard.categories.index') }}">
                        <i class="fa fa-th"></i>
                        <span>@lang('categories.categories')</span>
                    </a>
                </li>
            @endif

            {{-- products --}}
            @if (auth()->user()->isAbleTo('products-read'))
                <li>
                    <a href="{{ route('dashboard.products.index') }}">
                        <i class="fa fa-th"></i>
                        <span>@lang('products.products')</span>
                    </a>
                </li>
            @endif

            {{-- orders --}}
            @if (auth()->user()->isAbleTo('orders-read'))
                <li>
                    <a href="{{ route('dashboard.orders.index') }}">
                        <i class="fa fa-th"></i>
                        <span>@lang('orders.orders')</span>
                    </a>
                </li>
            @endif


            {{-- users --}}
            @if (auth()->user()->isAbleTo('users-read'))
                <li>
                    <a href="{{ route('dashboard.users.index') }}">
                        <i class="fa fa-th"></i>
                        <span>@lang('users.users')</span>
                    </a>
                </li>
            @endif

            {{-- <li><a href="{{ route('dashboard.categories.index') }}"><i class="fa fa-book"></i><span>@lang('site.categories')</span></a></li> --}}
            {{--  --}}
            {{--  --}}
            {{-- <li><a href="{{ route('dashboard.users.index') }}"><i class="fa fa-users"></i><span>@lang('site.users')</span></a></li> --}}

            {{-- <li class="treeview"> --}}
            {{-- <a href="#"> --}}
            {{-- <i class="fa fa-pie-chart"></i> --}}
            {{-- <span>??????????????</span> --}}
            {{-- <span class="pull-right-container"> --}}
            {{-- <i class="fa fa-angle-left pull-right"></i> --}}
            {{-- </span> --}}
            {{-- </a> --}}
            {{-- <ul class="treeview-menu"> --}}
            {{-- <li> --}}
            {{-- <a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a> --}}
            {{-- </li> --}}
            {{-- <li> --}}
            {{-- <a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a> --}}
            {{-- </li> --}}
            {{-- <li> --}}
            {{-- <a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a> --}}
            {{-- </li> --}}
            {{-- <li> --}}
            {{-- <a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a> --}}
            {{-- </li> --}}
            {{-- </ul> --}}
            {{-- </li> --}}
        </ul>

    </section>

</aside>
