<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // نحذف المستخدمين القدامى (اختياري)
        User::truncate();

        // إضافة مستخدم Active
        User::create([
            'name' => 'Ali Active',
            'email' => 'ali_active@example.com',
            'password' => Hash::make('password123'),
            'status' => 'Active',
        ]);

        // إضافة مستخدم Inactive
        User::create([
            'name' => 'Hassan Inactive',
            'email' => 'hassan_inactive@example.com',
            'password' => Hash::make('password123'),
            'status' => 'Inactive',
        ]);

        // مستخدمين أكثر للتجربة
        User::factory()->count(3)->create([
            'status' => 'Active'
        ]);

        User::factory()->count(2)->create([
            'status' => 'Inactive'
        ]);
    }
}