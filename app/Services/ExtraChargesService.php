
<?php
class ExtraChargesService
{
    public function apply(array $data): float
    {
        $total = 0;
        if (!empty($data['extra_luggage'])) $total += 10;
        if (!empty($data['child_seat'])) $total += 15 * $data['child_seat'];
        if (!empty($data['meet_greet'])) $total += 10;
        if (!empty($data['wait_minutes'])) $total += $data['wait_minutes'] * 0.50;
        return $total;
    }
}
