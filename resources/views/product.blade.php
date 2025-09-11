@extends('Layouts.master')

@section('content')
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text fw-bold"> Via -
                            </span>جميع منتجات</h3>
                        <p dir="rtl">تتوفر لدينا جميع المستلزمات التي تحتاجها.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $item)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="/single-product/{{ $item->id }}">
                                    <img src="{{ url($item->imagepath) }}"
                                        style="max-height: 250px !important; min-height: 250px !important" alt="">
                                </a>
                            </div>
                            <h3>{{ $item->name }}</h3>
                            <p class="product-price">
                                <span>{{ $item->quantity }}</span>{{ $item->price }} $
                            </p>
                            <p dir="rtl">{{ $item->description }}</p>

                            <a href="/addproducttocart/{{ $item->id }}" class="cart-btn my-3"><i
                                    class="fas fa-shopping-cart"></i> اضافة الى السلة</a><br>

                            @if (Auth::user() && (Auth::user()->role == 'admin' || Auth::user()->role == 'salesman'))
                                <a href="/removeproduct/{{ $item->id }}" class="btn btn-danger"><i
                                        class="fas fa-trash"></i> حذف المنتج </a>
                                <a href="/editproduct/{{ $item->id }}" class="btn btn-primary"><i
                                        class="fas fa-trash"></i> تعديل المنتج </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination دائمًا أسفل المنتجات --}}
            <div style="text-align: center;margin: 0 auto;">
                {{ $products->links('vendor.pagination.bootstrap-5') }}
            </div>


        </div>
    </div>
@endsection

<style>
    svg {
        height: 50px !important;
    }
</style>
