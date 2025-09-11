@extends('Layouts.master')

@section('content')
    <div class="container my-5" dir="rtl" style="text-align: right">

        <!-- عنوان الصفحة -->
        <div class="row mb-5 text-center">
            <div class="col">
                <h2 class="fw-bold"> أضف رأيك عن <span class=" fw-bold" style="color: #fc7536">- Via
                    </span></h2>
                <p class="text-muted">نحن نقدر رأيك لمساعدتنا على تحسين خدماتنا</p>
            </div>
        </div>

        <!-- نموذج إضافة رأي -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-5" style="border-radius:10px;">
                    <div class="card-header text-white fw-bold" style="background-color: #fc7536">
                        أضف رأيك
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('reviews.store') }}">
                            @csrf
                            <!-- الاسم -->
                            <div class="mb-3">
                                <label class="form-label">الاسم</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}" required>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- العنوان -->
                            <div class="mb-3">
                                <label class="form-label">العنوان</label>
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}"
                                    required>
                                @error('subject')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- الرسالة -->
                            <div class="mb-3">
                                <label class="form-label">رسالتك</label>
                                <textarea name="message" rows="5" class="form-control" placeholder="اكتب رسالتك" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- التقييم -->
                            <div class="mb-3">
                                <label class="form-label">التقييم</label>
                                <select name="rating" class="form-select w-auto" required>
                                    <option value="">اختر التقييم</option>
                                    <option value="1" @selected(old('rating') == 1)>★☆☆☆☆</option>
                                    <option value="2" @selected(old('rating') == 2)>★★☆☆☆</option>
                                    <option value="3" @selected(old('rating') == 3)>★★★☆☆</option>
                                    <option value="4" @selected(old('rating') == 4)>★★★★☆</option>
                                    <option value="5" @selected(old('rating') == 5)>★★★★★</option>
                                </select>
                                @error('rating')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- زر التعليق -->
                            <div class="text-end">
                                <button type="submit" class="btn  px-4" style="background-color: #fc7536">
                                    تعليق
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- التعليقات -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-4 text-end">التعليقات</h3>

                @if ($reviews->count() > 0)
                    <div class="list-group">
                        @foreach ($reviews as $item)
                            <div class="list-group-item mb-3 shadow-sm rounded border p-3">
                                <!-- الاسم + التاريخ + التقييم -->
                                <div
                                    class="d-flex justify-content-between align-items-start mb-2 flex-column flex-md-row text-end">
                                    <div class="text-end">
                                        <h5 class="mb-0 fw-bold" style="color: #fc7536">{{ $item->name }}</h5>
                                        <small class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    @if ($item->rating)
                                        <div class=" fs-6 mt-2 mt-md-0" style="color: #fc7536">
                                            @for ($i = 1; $i <= 5; $i++)
                                                {!! $i <= $item->rating ? '★' : '☆' !!}
                                            @endfor
                                        </div>
                                    @endif
                                </div>

                                <!-- العنوان -->
                                <p class="text-dark fw-bold mb-1">{{ $item->subject }}</p>

                                <!-- الرسالة -->
                                <p class="text-muted mb-0" style="word-break: break-word;">{{ $item->message }}</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $reviews->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-muted text-end">لا توجد تعليقات حتى الآن</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .list-group-item {
            background-color: #fff7f7;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .list-group-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h5 {
            font-size: 1.2rem;
        }

        .pagination {
            justify-content: flex-start !important;
            direction: rtl;
        }
    </style>
@endpush
