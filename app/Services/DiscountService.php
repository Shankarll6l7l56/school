
<?php
class DiscountService
{
    public function apply(float $fare, array $data): float
    {
        $discount = 0;
        if (!empty($data['promo_code']) && $data['promo_code'] === 'WELCOME10') {
            $discount = $fare * 0.10;
        } elseif (!empty($data['is_corporate'])) {
            $discount = $fare * 0.15;
        }

        return $discount;
    }
}
