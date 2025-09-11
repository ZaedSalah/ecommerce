@extends('Layouts.dash')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ $section == 'home' ? 'active' : '' }}"
                                href="{{ route('dashboard.index', ['section' => 'home']) }}">
                                <i class="bi bi-house-door"></i> الرئيسية
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ $section == 'orders' ? 'active' : '' }}"
                                href="{{ route('dashboard.index', ['section' => 'orders']) }}">
                                <i class="bi bi-receipt"></i> الطلبات
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ $section == 'categories' ? 'active' : '' }}"
                                href="{{ route('dashboard.index', ['section' => 'categories']) }}">
                                <i class="bi bi-tags"></i> الفئات
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ $section == 'products' ? 'active' : '' }}"
                                href="{{ route('dashboard.index', ['section' => 'products']) }}">
                                <i class="bi bi-box-seam"></i> المنتجات
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ $section == 'users' ? 'active' : '' }}"
                                href="{{ route('dashboard.index', ['section' => 'users']) }}">
                                <i class="bi bi-people"></i> المستخدمين
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ $section == 'reports' ? 'active' : '' }}"
                                href="{{ route('dashboard.index', ['section' => 'reports']) }}">
                                <i class="bi bi-bar-chart"></i> التقارير
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
                @switch($section)
                    @case('home')
                        @include('dashboard.sections.home')
                    @break

                    @case('orders')
                        @include('dashboard.sections.orders')
                    @break

                    @case('orderDetails')
                        @include('dashboard.sections.orderDetails')
                    @break

                    @case('categories')
                        @include('dashboard.sections.categories')
                    @break

                    @case('categoryProducts')
                        @include('dashboard.sections.categoryProducts')
                    @break

                    @case('productDetails')
                        @include('dashboard.sections.productDetails')
                    @break

                    @case('users')
                        @if (Auth::user() && Auth::user()->role == 'superadmin')
                            @include('dashboard.sections.users')
                        @endif
                    @break

                    @case('products')
                        @include('dashboard.sections.products')
                    @break

                    @case('reports')
                        @include('dashboard.sections.reports')
                    @break

                    @default
                        <h3>القسم غير موجود</h3>
                @endswitch
            </main>
        </div>
    </div>
@endsection
