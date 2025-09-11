@extends('layouts.dash')

@section('title', 'منتجات الفئة')

@section('content')
    <div class="container-fluid">

        <!-- العنوان الرئيسي -->
        <div class="mb-4 mt-5">
            <h2 class="fw-bold">منتجات الفئة: {{ $category->name }}</h2>
        </div>

        <!-- جدول المنتجات -->
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width:5%">#</th>
                        <th style="width:45%">اسم المنتج</th>
                        <th style="width:15%">السعر</th>
                        <th style="width:15%">الكمية</th>
                        <th style="width:20%">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($category->products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $product->name }}</td>
                            <td>{{ $product->price }} $</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                <a href="{{ route('dashboard.index', ['section' => 'productDetails', 'id' => $product->id]) }}"
                                    class="btn btn-info btn-sm shadow-sm">
                                    <i class="bi bi-eye"></i> تفاصيل
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- زر العودة -->
        <div class="mt-3">
            <a href="{{ route('dashboard.index', ['section' => 'categories']) }}"
                class="btn btn-secondary btn-lg shadow-sm">
                <i class="bi bi-arrow-left-circle"></i> العودة للفئات
            </a>
        </div>

    </div>
@endsection
