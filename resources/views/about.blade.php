@extends('Layouts.master')
@section('content')
    <!-- about start -->
    <section id="about" class="py-5" style="background-color: #fff7f7;">
        <div class="container">
            <!-- العنوان -->
            <div class="text-center mb-5">
                <h2 class="fw-bold display-5"><i class="fa-solid fa-circle-info"></i><span class="text-primary fw-bold">Via
                        -</span> من نحن </h2>
                <p class="text-muted fs-5" style="direction: rtl;">
                    مركز <span class="text-primary fw-bold">Via</span> لكافة الملابس
                </p>
                <hr class="mx-auto" style="width: 100px; border-top: 3px solid #dc3545;">
            </div>

            <!-- المحتوى -->
            <div class="row align-items-center">
                <!-- الصورة -->
                <div class="col-lg-6 mb-4 mb-lg-0 text-center">
                    <div class="card shadow-sm border-0 rounded overflow-hidden image-hover">
                        <img src="{{ asset('assets/img/about.jpg') }}" class="card-img-top img-fluid rounded"
                            alt="about image">
                    </div>
                </div>

                <!-- النص -->
                <div class="col-lg-6" style="direction: rtl; text-align: right;">
                    <div class="card shadow-sm border-0 rounded p-4">
                        <p class="fs-5">
                            <span class="text-primary fw-bold">Via</span> – ستايل يواكبك إنت وعائلتك! 👕👗🧒
                            <br>
                            بـ <span class="text-primary fw-bold">Via</span> جمّعنا أحلى تشكيلة ملابس لكل الأعمار، ولكل
                            الأذواق!
                            رجالي، نسائي، وللأطفال بعد – لبس عصري، مريح، وستايله يجنن!
                        </p>
                        <p class="fs-5">
                            ✨ خامات تريحك.<br>
                            🔥 موديلات تواكب الموضة.<br>
                            🧒 كل أفراد العائلة يلكون شي يعجبهم.<br>
                            🛍️ تسوّق سهل وسريع.<br><br>
                            لا تعب روحك وتدور، بـ <span class="text-primary fw-bold">Via</span> تحصل كلشي بمكان واحد!
                            خلي لبسك يحچي عنك، وتعال جرّبها ويانا! 😉
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about end -->

    @push('styles')
        <style>
            .image-hover img {
                transition: transform 0.4s ease, box-shadow 0.4s ease;
                max-height: 300px;
                /* تصغير حجم الصورة */
            }

            .image-hover:hover img {
                transform: scale(1.05) translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }

            /* تكبير الخط للنصوص */
            .fs-5 {
                font-size: 1.2rem !important;
            }

            @media (max-width: 768px) {
                .image-hover img {
                    max-height: 300px;
                }
            }
        </style>
    @endpush
@endsection
