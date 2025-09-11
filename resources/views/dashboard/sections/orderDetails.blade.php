@extends('layouts.dash')
@section('title', 'تفاصيل الطلب')

@section('content')
    <div class="container my-4">
        <!-- الأزرار -->
        <div class="d-flex justify-content-between mb-5 mt-5 no-print">
            <a href="{{ route('dashboard.ordersPage') }}" class="btn btn-secondary">
                رجوع إلى الطلبات
            </a>
            <button onclick="window.print()" class="btn btn-primary ">
                طباعة
            </button>
        </div>

        <!-- عنوان -->
        <div class="text-center mb-4 mt-3">
            <h3 class="fw-bold">تفاصيل الطلب <span class="text-primary">#{{ $order->id }}</span></h3>
        </div>

        <!-- بطاقة معلومات العميل -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                معلومات العميل
            </div>
            <div class="card-body text-dark">
                <div class="row mb-2">
                    <div class="col-md-6"><strong>الاسم:</strong> {{ $order->name ?? 'غير معروف' }}</div>
                    <div class="col-md-6"><strong>الإيميل:</strong> {{ $order->email ?? 'غير معروف' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>الهاتف:</strong> {{ $order->phone ?? 'غير معروف' }}</div>
                    <div class="col-md-6"><strong>العنوان:</strong> {{ $order->address ?? 'غير معروف' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>ملاحظة:</strong> {{ $order->note ?? '-' }}</div>
                    <div class="col-md-6"><strong>المستخدم في النظام:</strong>
                        {{ $order->user->name ?? 'غير مرتبط بمستخدم' }}</div>
                </div>
                <div class="row">
                    <div class="col-md-12"><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- جدول المنتجات -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white fw-bold">
                المنتجات
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>المجموع</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($order->orderdetails as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'غير معروف' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price }} $</td>
                                    <td class="fw-bold">{{ $item->quantity * $item->price }} $</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--باستتخدام accessor المجموع النهائي -->

        <div class="text-end">
            <h5 class="fw-bold">
                إجمالي الطلب: <span class="text-success">{{ number_format($order->total, 2) }} $</span>
            </h5>
        </div>


    </div>
@endsection

@push('styles')
    <style>
        /* إخفاء الأزرار عند الطباعة */
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
@endpush
