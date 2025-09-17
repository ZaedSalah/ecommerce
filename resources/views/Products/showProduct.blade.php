@extends('Layouts.master')

@section('content')
    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="{{ asset($product->imagepath) }}" alt="صورة المنتج">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $product->name }}</h3>
                        <h4>القسم : {{ $product->Category->name }}</h4>
                        <p class="single-product-pricing"><span>الكمية : {{ $product->quantity }}</span>
                            ${{ $product->price }}</p>
                        <p>{{ $product->description }}</p>
                        <div class="single-product-form">

                            <a href="/addproducttocart/{{ $product->id }}" class="cart-btn"><i
                                    class="fas fa-shopping-cart"></i> اضافة الى سلة</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single product -->

    <div class="testimonail-section mt-80 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <div class="testimonial-sliders d-flex flex-wrap justify-content-center gap-4">

                        @foreach ($product->ProductPhotos as $item)
                            <div class="single-testimonial-slider p-4 rounded shadow-sm ">
                                <div class="client-avater mb-3">
                                    <img src="{{ asset($item->imagepath) }}" alt=""
                                        style="width: 200px;max-width: none; height: 150px !important;border: 5px; border-radius: 20px 100px">
                                </div>
                                <div class="client-meta">
                                    <div class="last-icon mt-3">
                                        <i class="fas fa-quote-right" style="color: #ccc;"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end testimonail-section -->

    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">المنتجات</span> ذات الصلة</h3>
                        <p dir="rtl">تتوفر لدينا جميع المستلزمات التي تحتاجها.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($relatedProducts as $item)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="/single-product/{{ $item->id }}"><img src="{{ url($item->imagepath) }}"
                                        style="max-height: 250px !important; min-height: 250px !important"
                                        alt=""></a>
                            </div>
                            <h3>{{ $item->name }}</h3>
                            <p class="product-price">
                                <span>{{ $item->quantity }}</span>{{ $item->price }} $
                            </p>
                            <p dir="rtl">{{ $item->description }}</p>

                            <a href="/addproducttocart/{{ $item->id }}" class="cart-btn"><i
                                    class="fas fa-shopping-cart"></i> اضافة الى السلة</a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
<style>
    svg {
        height: 50px !important;
    }
</style>
