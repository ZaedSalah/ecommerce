@extends('layouts.dash')

@section('title', 'تفاصيل المنتج')

@section('content')
    <div class="container-fluid">

        <!-- العنوان الرئيسي -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-5 mb-4 gap-2">
            <h3 class="fw-bold">تفاصيل المنتج: {{ $product->name }}</h3>
            <a href="{{ route('dashboard.index', ['section' => 'products']) }}" class="btn btn-secondary btn-lg shadow-sm">
                <i class="bi bi-arrow-left-circle"></i> العودة للمنتجات
            </a>

        </div>

        <!-- بطاقة تفاصيل المنتج -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-3 align-items-center">

                    @if ($product->imagepath)
                        <div class="col-md-4 text-center">
                            <img src="{{ asset($product->imagepath) }}" alt="صورة المنتج"
                                class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                        </div>
                    @endif

                    <div class="@if ($product->imagepath) col-md-8 @else col-12 @endif">
                        <p><strong>الفئة:</strong> {{ $product->category?->name ?? 'بدون فئة' }}</p>
                        <p><strong>الكمية:</strong> {{ $product->quantity }}</p>
                        <p><strong>السعر:</strong> {{ $product->price }} $</p>
                        <p><strong>الوصف:</strong> {{ $product->description }}</p>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
