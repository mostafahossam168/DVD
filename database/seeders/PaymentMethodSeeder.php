<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'فودافون كاش', 'code' => 'vodafone_cash', 'is_active' => true],
            ['name' => 'إنستاباي', 'code' => 'instapay', 'is_active' => true],
        ];
        foreach ($methods as $m) {
            PaymentMethod::firstOrCreate(
                ['code' => $m['code']],
                ['name' => $m['name'], 'is_active' => $m['is_active']]
            );
        }
    }
}
