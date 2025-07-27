<?php
class TimePricingService
{
    public function apply(array $data): float
    {
        $waitingMinutes = $data['waiting_minutes'] ?? 0;
        $hourlyHours = $data['hourly_hours'] ?? 0;

        return ($waitingMinutes * 0.50) + ($hourlyHours * 80);
    }
}
