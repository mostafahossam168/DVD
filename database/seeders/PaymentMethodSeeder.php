<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'فودافون كاش',
                'code' => 'vodafone_cash',
                'account_name' => setting('website_name') ?: 'فاهم',
                'account_number' => setting('whatsapp') ?: null,
                'notes' => 'حوّل على الرقم ثم ارفع صورة التحويل',
                'is_active' => true,
            ],
            [
                'name' => 'إنستاباي',
                'code' => 'instapay',
                'account_name' => setting('website_name') ?: 'فاهم',
                'account_number' => setting('phone') ?: null,
                'notes' => 'حوّل على الحساب ثم اكتب مرجع التحويل',
                'is_active' => true,
            ],
        ];
        foreach ($methods as $m) {
            PaymentMethod::updateOrCreate(
                ['code' => $m['code']],
                [
                    'name' => $m['name'],
                    'account_name' => $m['account_name'],
                    'account_number' => $m['account_number'],
                    'notes' => $m['notes'],
                    'is_active' => $m['is_active'],
                ]
            );
        }
    }
}
