@extends('Layouts.master')

@section('content')
    <div class="container my-5">

        <h2 class="mb-4 text-center">تعديل الفئة</h2>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- الاسم -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم الفئة</label>
                                <input type="text" name="name" class="form-control" value="{{ $category->name }}"
                                    required>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- الوصف -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">الوصف</label>
                                <textarea name="description" class="form-control" rows="4">{{ $category->description }}</textarea>
                                @error('description')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- الصورة -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">الصورة الحالية</label><br>
                                @if ($category->imagepath)
                                    <img src="{{ asset($category->imagepath) }}" alt="صورة الفئة" width="150"
                                        class="mb-3 rounded">
                                @else
                                    <p class="text-muted">لا توجد صورة حالية</p>
                                @endif
                                <input type="file" name="photo" class="form-control mt-2">
                                @error('photo')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                                <a href="{{ url('/') }}" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
