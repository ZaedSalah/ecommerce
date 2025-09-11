@extends('Layouts.master')

@section('content')

    @if (auth()->check())
        <div class="row mt-150 mb-150">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">اضافة</span> منتج جديد</h3>
                </div>
            </div>
        </div>

        <!-- add product -->
        <div class="product-from-section mt-150 mb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-5 mb-lg-0">
                        <div class="contact-form">
                            <form method="POST" enctype="multipart/form-data" action="/storeproduct" dir="rtl">
                                @csrf()

                                {{-- اسم المنتج --}}
                                <p>
                                    <input style="width: 100%; font-size: 24px;" type="text" placeholder="اسم المنتج"
                                        name="name" id="name" value="{{ old('name') }}" required>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </p>

                                {{-- سعر الشراء – السعر – الكمية --}}
                                <p style="display: flex; gap: 10px;">
                                    <input style="width: 33%; font-size: 24px;" type="number" placeholder="سعر الشراء"
                                        name="purchase_price" value="{{ old('purchase_price') }}" required>
                                    <span class="text-danger">
                                        @error('purchase_price')
                                            {{ $message }}
                                        @enderror
                                    </span>

                                    <input style="width: 33%; font-size: 24px;" type="number" placeholder="السعر"
                                        name="price" value="{{ old('price') }}" id="price" required>
                                    <span class="text-danger">
                                        @error('price')
                                            {{ $message }}
                                        @enderror
                                    </span>

                                    <input style="width: 33%; font-size: 24px;" type="number" placeholder="الكمية"
                                        name="quantity" value="{{ old('quantity') }}" id="quantity" required>
                                    <span class="text-danger">
                                        @error('quantity')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </p>

                                {{-- الوصف --}}
                                <p>
                                    <textarea name="description" id="description" cols="30" rows="10" placeholder="الوصف" style="font-size: 24px;"
                                        required>{{ old('description') }}</textarea>
                                    <span class="text-danger">
                                        @error('description')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </p>

                                {{-- الفئة --}}
                                <p>
                                    <select class="form-control" style="font-size: 24px;" required name="category_id"
                                        id="category_id">
                                        @foreach ($allcategories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        @error('category_id')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </p>

                                {{-- الصورة --}}
                                <p>
                                    <input type="file" name="photo" id="photo" class="form-control">
                                    <span class="text-danger">
                                        @error('photo')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </p>

                                {{-- زر الحفظ --}}
                                @if ((Auth::user() && Auth::user()->role == 'admin') || (Auth::user() && Auth::user()->role == 'superadmin'))
                                    <p style="text-align: right">
                                        <input style="font-size: 24px;" type="submit" value="حفظ">
                                    </p>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add product-->
    @else
        status: {{ auth()->check() }}
    @endif

@endsection
