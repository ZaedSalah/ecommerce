@extends('Layouts.master')

@section('content')
    <!-- check out section -->
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">

                            @foreach ($order as $item)
                                <div class="card single-accordion">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                تفاصيل الطلب
                                                {{ $item->id }}
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="billing-address-form">
                                                <form action="">
                                                    <p><input required type="text" id="address" name="address"
                                                            placeholder="created_at"
                                                            value=" تم انشاء الطلب بتاريخ : {{ $item->created_at }}"></p>
                                                    <p><input required type="text" id="name" name="name"
                                                            placeholder="اسمك" value="{{ $item->name }}">
                                                    </p>
                                                    <p><input required type="email" id="email" name="email"
                                                            placeholder="البريد الالكتروني" value="{{ $item->email }}">
                                                    </p>
                                                    <p><input required type="text" id="address" name="address"
                                                            placeholder="العنوان" value="{{ $item->address }}"></p>

                                                    <p><input required type="tel" id="phone" name="phone"
                                                            placeholder="رقم الهاتف" value="{{ $item->phone }}">
                                                    </p>
                                                    <p>
                                                        <textarea name="note" id="note" cols="30" rows="10" placeholder="ملاحظاتك ...">{{ $item->note }}</textarea>
                                                    </p>
                                                </form>
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-12">
                                                        <div class="cart-table-wrap">
                                                            <table class="cart-table">
                                                                <thead class="cart-table-head">
                                                                    <tr class="table-head-row">
                                                                        <th class="product-remove"></th>
                                                                        <th class="product-image"> صورة المنتج</th>
                                                                        <th class="product-name">اسم المنتج</th>
                                                                        <th class="product-price">السر</th>
                                                                        <th class="product-quantity">الكمية</th>
                                                                        <th class="product-total">المجموع</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($item->Orderdetails as $detail)
                                                                        <tr class="table-body-row">

                                                                            <td class="product-image"><img
                                                                                    src="{{ asset($detail->product->imagepath) }}"
                                                                                    alt="">
                                                                            </td>
                                                                            <td class="product-name">
                                                                                <a
                                                                                    href="/single-product/{{ $detail->product->id }}">
                                                                                    {{ $detail->product->name }}
                                                                                </a>
                                                                            </td>
                                                                            <td class="product-price">
                                                                                {{ $detail->product->price }}</td>
                                                                            <td class="product-quantity">
                                                                                {{ $detail->quantity }}</td>
                                                                            <td class="product-total">
                                                                                {{ $detail->product->price * $detail->quantity }}$
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

                                                                            {{ $item->orderDetails->sum(function ($x) {
                                                                                return $x->product->price * $x->quantity;
                                                                            }) }}
                                                                            $
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end check out section -->
@endsection
