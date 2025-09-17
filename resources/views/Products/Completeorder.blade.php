@extends('Layouts.master')

@section('content')
    <!-- check out section -->
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <!-- معلومات المشتري -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            ادخل معلوماتك
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="billing-address-form">
                                            <form action="{{ route('store.order') }}" method="POST" id="store-order">
                                                @csrf
                                                <p><input required type="text" name="name" placeholder="اسمك"></p>
                                                <p><input required type="email" name="email"
                                                        placeholder="البريد الالكتروني"></p>
                                                <p><input required type="text" name="address" placeholder="العنوان"></p>
                                                <p><input required type="tel" name="phone" placeholder="رقم الهاتف">
                                                </p>
                                                <p>
                                                    <textarea name="note" cols="30" rows="5" placeholder="ملاحظات ..."></textarea>
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تفاصيل السلة -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            تفاصيل السلة
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card-details">
                                            <div class="cart-section mt-150 mb-150">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-lg-8 col-md-12">
                                                            <div class="cart-table-wrap">
                                                                <table class="cart-table">
                                                                    <thead class="cart-table-head">
                                                                        <tr class="table-head-row">
                                                                            <th class="product-remove"></th>
                                                                            <th class="product-image">صورة المنتج</th>
                                                                            <th class="product-name">اسم المنتج</th>
                                                                            <th class="product-price">السعر</th>
                                                                            <th class="product-quantity">الكمية</th>
                                                                            <th class="product-total">المجموع</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($cartProducts as $item)
                                                                            <tr class="table-body-row">
                                                                                <td class="product-remove">
                                                                                    <a
                                                                                        href="/deletcartitem/{{ $item->id }}">
                                                                                        <i class="far fa-window-close"></i>
                                                                                    </a>
                                                                                </td>
                                                                                <td class="product-image">
                                                                                    <img src="{{ asset($item->product->imagepath) }}"
                                                                                        alt="">
                                                                                </td>
                                                                                <td class="product-name">
                                                                                    <a
                                                                                        href="/single-product/{{ $item->product->id }}">
                                                                                        {{ $item->product->name }}
                                                                                    </a>
                                                                                </td>
                                                                                <td class="product-price">
                                                                                    {{ $item->product->price }}</td>
                                                                                <td class="product-quantity">
                                                                                    {{ $item->quantity }}</td>
                                                                                <td class="product-total">
                                                                                    {{ $item->product->price * $item->quantity }}$
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="total-section">
                                                                <table class="total-table">
                                                                    <thead class="total-table-head">
                                                                        <tr class="table-total-row">
                                                                            <th>المجموع</th>
                                                                            <th>السعر</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="total-data">
                                                                            <td><strong>السعر الاجمالي: </strong></td>
                                                                            <td>
                                                                                {{ $cartProducts->sum(fn($item) => $item->product->price * $item->quantity) }}$
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end cart -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- زر الدفع -->
                <div class="col-lg-12 mt-5">
                    <button type="submit" form="store-order" class="boxed-btn black">
                        ادفع الان
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end check out section -->
@endsection
