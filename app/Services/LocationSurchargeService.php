<?php
class LocationSurchargeService
{
    public function apply(array $data): float
    {
        $location = $data['location'];
        $charges = [
            'Melbourne Airport' => 15,
            'Sydney Airport' => 18,
            'CBD' => 10
        ];

        return $charges[$location] ?? 0;
    }
}
