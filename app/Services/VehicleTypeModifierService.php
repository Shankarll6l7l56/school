<?php
class VehicleTypeModifierService
{
    public function apply(array $data): float
    {
        $distance = $data['distance'];
        $type = $data['vehicle_type'];
        $fare = 0;

        switch ($type) {
            case 'sedan':
                $fare = $distance * 1.0;
                break;
            case 'suv':
                $fare = $distance * 1.5;
                break;
            case 'luxury':
            case 'van':
                $fare = $distance * 2.0 + 25;
                break;
        }

        return $fare;
    }
}
