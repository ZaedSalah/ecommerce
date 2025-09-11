@extends('Layouts.master')
@section('content')
    <!-- Contact Start -->
    <section id="contact" class="py-5" style="background-color: #fff7f7;">
        <div class="container">
            <!-- العنوان -->
            <div class="text-center mb-5">
                <h2 class="fw-bold display-5"><i class="fas fa-envelope text-primary"></i> تواصل معنا</h2>
                <p class="text-muted fs-5" style="direction: rtl;">يسعدنا تواصلك معنا لأي استفسار أو اقتراح</p>
                <hr class="mx-auto" style="width: 100px; border-top: 3px solid #fc7536;">
            </div>

            <div class="row">
                <!-- نموذج الرسالة -->
                <div class="col-lg-6 mb-4" style="text-align: end">
                    <div class="card shadow-sm border-0 rounded p-4">

                        {{-- رسائل النجاح --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- رسائل الخطأ --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" class="form-control" style="text-align: end" id="name"
                                    name="name" required
                                    value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}">
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الالكتروني</label>
                                <input type="email" class="form-control" style="text-align: end" id="email"
                                    name="email" required
                                    value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">الموضوع</label>
                                <input type="text" class="form-control"style="text-align: end" id="subject"
                                    name="subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">الرسالة</label>
                                <textarea class="form-control"style="text-align: end" id="message" name="message" rows="5"
                                    placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit"
                                    class="text-white btn px-4"style="background-color: #fc7536">إرسال</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- معلومات التواصل + الخريطة -->
                <div class="col-lg-6" style="text-align: end">
                    <div class="card shadow-sm border-0 rounded p-4 mb-4">
                        <h5 class="fw-bold mb-3">معلومات التواصل</h5>
                        <p><i class="fas fa-map-marker-alt" style="color: #fc7536"></i> العراق - بابل</p>
                        <p><i class="fas fa-envelope" style="color: #fc7536"></i> zaed4149@gmail.com</p>
                        <p><i class="fas fa-phone" style="color: #fc7536"></i> +964 773 9770 366</p>
                    </div>

                    <div class="card shadow-sm border-0 rounded overflow-hidden">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d23162.123456789!2d44.0000!3d32.5000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x123456789abcdef%3A0xabcdef123456789!2sBabel%2C%20Iraq!5e0!3m2!1sen!2s!4v1694111111111"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact End -->

    @push('styles')
        <style>
            .card {
                background-color: #fff;
            }

            .form-control:focus {
                border-color: #dc3545;
                box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            }

            .btn-danger {
                transition: all 0.3s ease;
            }

            .btn-danger:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
            }

            p {
                font-size: 1.1rem;
            }
        </style>
    @endpush
@endsection
