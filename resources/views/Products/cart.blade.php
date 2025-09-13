@extends('Layouts.master')

@section('content')
    <!-- cart -->
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
                                    <th class="product-quantity">الكمية </th>
                                    <th class="product-total">المجموع</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartProducts as $item)
                                    <tr class="table-body-row">
                                        <td class="product-remove">
                                            <form action="{{ url('/cart/remove/' . $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="border:none; background:none; cursor:pointer;">
                                                    <i class="far fa-window-close"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="product-image">
                                            <img src="{{ asset($item->product->imagepath) }}" alt="">
                                        </td>
                                        <td class="product-name">
                                            <a href="/single-product/{{ $item->product->id }}">
                                                {{ $item->product->name }}
                                            </a>
                                        </td>
                                        <td class="product-price">{{ $item->product->price }}</td>
                                        <td class="product-quantity">{{ $item->quantity }}</td>
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
                                    <th>المجموع </th>
                                    <th>السعر</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="total-data">
                                    <td><strong>السعر الاجمالي: </strong></td>
                                    <td>

                                        {{ $cartProducts->sum(function ($item) {
                                            return $item->product->price * $item->quantity;
                                        }) }}
                                        $
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-buttons">
                            <a href="/Completeorder" class="boxed-btn black">اطلب الان</a>
                            <a href="/previousorder" class="boxed-btn black"> الطلبات السابقة </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- end cart -->
@endsection
