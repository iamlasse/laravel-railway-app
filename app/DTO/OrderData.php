<?php

namespace App\DTO;

use Illuminate\Support\Arr;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class OrderData
{
    public function __construct(
        public string $name,
        public int $price,
        public int $plan_id,
        public int $plan_data,
        public int $price_new,
        public int $price_org,
        public int $plan_count,
        public bool $is_vaxel_plan,
        public int $vaxel_plan_count,
        public int $mobile_plan_count
    ) {
    }


    public static function fromArray($data)
    {
        return new self(
            Arr::get($data, "name"),
            Arr::get($data, "price"),
            Arr::get($data, "plan_id"),
            Arr::get($data, "plan_data"),
            Arr::get($data, "price_new"),
            Arr::get($data, "price_org"),
            Arr::get($data, "plan_count"),
            Arr::get($data, "is_vaxel_plan"),
            Arr::get($data, "vaxel_plan_count"),
            Arr::get($data, "mobile_plan_count")
        );
    }

    public function __set($name, $value)
    {
        throw new MethodNotAllowedException(['__construct', 'fromArray'], "Object is immutable");
    }
}
