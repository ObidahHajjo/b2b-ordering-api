<?php

namespace App\Services;

class ShippingCalculatorService
{
    /**
     * Calculate shipping from the total weight.
     *
     * @param  float  $weight  Cart total weight.
     * @return float Shipping price.
     */
    public function calculate(float $weight): float
    {
        /** @var array<int, array<string, float|null>> $tiers */
        $tiers = config('company.shipping.tiers', []);

        foreach ($tiers as $tier) {
            $maxWeight = $tier['max_weight'];
            if ($maxWeight === null || $weight <= $maxWeight) {
                return (float) $tier['price'];
            }
        }

        return 0.0;
    }
}
