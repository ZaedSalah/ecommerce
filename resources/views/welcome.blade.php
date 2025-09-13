@extends('Layouts.master')

@section('content')
    {{ Session('date') }}

    <!-- product section -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">اقسام</span> الموقع</h3>
                        <p>
                            متعة التسوق عبر فروعنا
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($categories as $item)
                    <div class="col-lg-4 col-md-6 text-center mb-4">
                        <div class="card shadow border-0 h-100">
                            <div class="product-image">
                                <a href="/product/{{ $item->id }}">
                                    <img src="{{ asset($item->imagepath) }}" class="card-img-top"
                                        style="max-height: 250px !important; min-height: 250px !important; object-fit:cover;"
                                        alt="">
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text text-muted">{{ $item->description }}</p>

                                @if (Auth::check() && Auth::user()->role == 'superadmin')
                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                        <!-- تعديل -->
                                        <a href="{{ route('categories.edit', $item->id) }}"
                                            class="btn btn-sm btn-warning mx-4">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>

                                        <!-- حذف -->
                                        <form action="{{ route('categories.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <!-- end product section -->
@endsection
