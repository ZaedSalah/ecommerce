@extends('Layouts.master')

@section('content')
    <div class="container mt-5 mb-5 text-center">
        <div class="row justify-content-center">

            <div class="col-md-9">
                <form action="storeProductImage" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- to request id product to edit product in function -->
                    <input type="hidden" placeholder="" name="product_id" id="product_id" value="{{ $product->id }}">
                    <div class="form-group mb-4">
                        <input type="file" class="form-control" name="photo" id="photo"
                            style="background-color: rgb(224, 183, 0);">
                        <span class="text-danger">
                            @error('photo')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <button type="submit" class="btn btn-success mb-5">رفع الصورة</button>
                </form>
            </div>

            @foreach ($productImages as $item)
                <div class="col-md-4 col-sm-6 mt-5">
                    <img src="{{ asset($item->imagepath) }}" class="img-fluid mb-3" alt="صورة المنتج"
                        style="max-height: 300px;">
                    <br>
                    <a href="/removeproductphoto/{{ $item->id }}" class="btn btn-danger">
                        <i class="fas fa-trash"></i> حذف الصورة
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
