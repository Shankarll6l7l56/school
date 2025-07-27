<?php
namespace App\Services\FareCalculator;

class FareCalculatorService
{
    public function calculate(array $data): float
    {
        $fare = 0;

        $fare += (new BaseFareService())->apply($data);
        $fare += (new DistancePricingService())->apply($data);
        $fare += (new TimePricingService())->apply($data);
        $fare += (new VehicleTypeModifierService())->apply($data);
        $fare += (new LocationSurchargeService())->apply($data);
        $fare = (new SurgePricingService())->apply($fare, $data);
        $fare += (new ExtraChargesService())->apply($data);
        $fare -= (new DiscountService())->apply($fare, $data);
        $fare = (new MinimumFareService())->enforceMinimum($fare);

        return round($fare, 2);
    }
}
?>