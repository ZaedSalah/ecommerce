<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تحقق إذا كان الأدمن موجود بالفعل
        $adminEmail = 'admin@example.com';

        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => $adminEmail,
                'password' => Hash::make('024680#z'),
                'role' => 'superadmin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }
    }
}