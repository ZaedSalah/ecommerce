@extends('Layouts.master')

@section('content')
    <!-- products -->
    <div class="product-section mt-150 mb-150">
        <div class="container">

            <div class="row mb-4">
                <div class="col text-center">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <a href="{{ route('categories.add') }}" class="btn btn-danger">
                            <i class="fas fa-plus"></i> إضافة فئة جديدة
                        </a>
                    @endif
                </div>
            </div>

            {{-- فلاتر الفئات --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            @foreach ($categories as $item)
                                <li data-filter="._{{ $item->id }}">{{ $item->name }}</li>
                            @endforeach
                            <li class="active" data-filter="*">الكل</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- المنتجات --}}
            <div class="row product-lists">
                @foreach ($products as $item)
                    <div class="col-lg-4 col-md-6 text-center _{{ $item->category_id }}">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="single-product.html">
                                    <img src="{{ asset($item->imagepath) }}" style="max-height: 250px; min-height:250px"
                                        alt="">
                                </a>
                            </div>
                            <h3>{{ $item->name }}</h3>
                            <p class="product-price"><span>Price: </span> {{ $item->price }}$ </p>
                            <p class="product-price"><span>Quantity: </span> {{ $item->quantity }} </p>
                            <a href="cart.html" class="cart-btn mb-2"><i class="fas fa-shopping-cart"></i> اضافة الى
                                السلة</a><br>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination دائمًا أسفل المنتجات --}}
            <div class="pagination-container mt-4 text-center">
                {{ $products->links('vendor.pagination.bootstrap-5') }}
            </div>

        </div>
    </div>
    <!-- end products -->
@endsection
<style>
    .pagination-container {
        clear: both;
        /* يمنع التداخل مع المنتجات */
        margin-top: 30px;
    }

    .pagination .page-link {
        min-width: 80px;
        /* لضمان عرض الزر بشكل متساوي */
        text-align: center;
    }
</style>
