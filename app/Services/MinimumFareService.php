<?php
class MinimumFareService
{
    public function enforceMinimum(float $fare): float
    {
        return $fare < 50 ? 50 : $fare; // Minimum fare logic
    }
}
