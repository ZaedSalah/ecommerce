<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// تحميل Composer autoload
require __DIR__ . '/../vendor/autoload.php';

// تحميل تطبيق Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// إنشاء Kernel للتعامل مع الطلبات
$kernel = $app->make(Kernel::class);

// التقاط الطلب الحالي
$request = Request::capture();

// معالجة الطلب والحصول على الاستجابة
$response = $kernel->handle($request);

// إرسال الاستجابة للمستخدم
$response->send();

// إنهاء معالجة الطلب (للـ middleware وما بعد الاستجابة)
$kernel->terminate($request, $response);