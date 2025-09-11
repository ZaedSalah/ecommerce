@extends('Layouts.master')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h3 class="mb-4 text-center orange-text">إضافة فئة جديدة</h3>

                        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">اسم الفئة</label>
                                <input type="text" name="name" class="form-control" placeholder="أدخل اسم الفئة"
                                    required>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- الوصف -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">الوصف</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">صورة الفئة (اختياري)</label>
                                <input type="file" name="photo" class="form-control">
                                @error('photo')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn" style="background-color: #fc7536">حفظ</button>
                                <a href="/category" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
