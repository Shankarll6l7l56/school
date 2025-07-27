<?php

class DistancePricingService
{
    public function apply(array $data): float
    {
        $distance = $data['distance'];
        $fare = 0;

        if ($distance <= 10) {
            $fare = $distance * 2;
        } elseif ($distance <= 30) {
            $fare = 10 * 2 + ($distance - 10) * 1.5;
        } else {
            $fare = 10 * 2 + 20 * 1.5 + ($distance - 30) * 1;
        }

        return $fare;
    }
}
