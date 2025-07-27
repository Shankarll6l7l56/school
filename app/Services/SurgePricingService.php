<?php
class SurgePricingService
{
    public function apply(float $fare, array $data): float
    {
        $time = $data['pickup_time']; // DateTime instance
        $dayOfWeek = $time->format('N'); // 1 = Monday ... 7 = Sunday
        $hour = (int)$time->format('H');

        if (($dayOfWeek <= 5 && ($hour >= 7 && $hour <= 10 || $hour >= 16 && $hour <= 20))) {
            return $fare * 1.20;
        } elseif ($hour >= 22 || $hour < 5) {
            return $fare * 1.15;
        }

        return $fare;
    }
}
