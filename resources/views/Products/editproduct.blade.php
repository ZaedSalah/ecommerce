@extends('Layouts.master')

@section('content')
    <div class="row mt-150 mb-150">
        <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-title">
                <h3><span class="orange-text">تعديل</span> المنتج </h3>
            </div>
        </div>
    </div>

    <div class="contact-from-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-5 mb-lg-0">
                    <div class="contact-form">

                        <form method="POST" enctype="multipart/form-data" action="/storeproduct" dir="rtl">
                            @csrf()
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <p>
                                <input style="width: 100%;font-size: 24px;" type="text" placeholder="اسم المنتج"
                                    name="name" value="{{ $product->name }}" required>
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </p>

                            <p style="display: flex; gap: 10px;">
                                <input style="width: 33%;font-size: 24px;" type="number" placeholder="سعر البيع"
                                    name="price" value="{{ $product->price }}" required>

                                <input style="width: 33%;font-size: 24px;" type="number" placeholder="سعر الشراء"
                                    name="purchase_price" value="{{ $product->purchase_price }}" required>

                                <input style="width: 33%;font-size: 24px;" type="number" placeholder="الكمية"
                                    name="quantity" value="{{ $product->quantity }}" required>
                            </p>
                            <span class="text-danger">
                                @error('price')
                                    {{ $message }}
                                @enderror
                            </span>
                            <span class="text-danger">
                                @error('purchase_price')
                                    {{ $message }}
                                @enderror
                            </span>
                            <span class="text-danger">
                                @error('quantity')
                                    {{ $message }}
                                @enderror
                            </span>

                            <p>
                                <textarea name="description" cols="30" rows="10" placeholder="الوصف" style="font-size: 24px;" required>{{ $product->description }}</textarea>
                            </p>
                            <span class="text-danger">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>

                            <p>
                                <select class="form-control" style="font-size: 24px;" required name="category_id">
                                    @foreach ($allcategories as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $product->category_id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @error('category_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </p>

                            <p>
                                <input type="file" name="photo" class="form-control">
                                <span class="text-danger">
                                    @error('photo')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </p>

                            <p>
                                <img src="{{ asset($product->imagepath) }}" width="250" height="250" alt="image">
                            </p>

                            <p><input style="font-size: 24px;" type="submit" value="حفظ"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
