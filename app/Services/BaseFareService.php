<?php
class BaseFareService
{
    public function apply(array $data): float
    {
        return 20; // base fare, can pull from DB
    }
}
