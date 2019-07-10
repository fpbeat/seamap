<?php

namespace leafTracker\Repositories;

use leafTracker\Entities\PointEntity;
use leafTracker\Repositories\Contracts\PointInterface;
use leafTracker\Helpers\Arr;
use Spot\Locator;

class PointEntityRepository implements PointInterface {

    private $entity;

    public function __construct(PointEntity $entity, Locator $locator) {
        $this->entity = $locator->mapper(get_class($entity));
    }

    public function getData() {
        $pool = [];

        foreach ($this->entity->select()->order(['id' => 'DESC'])->limit(100) as $point) {
            $pool[] = Arr::extract($point->toArray(), ['lat', 'lng', 'message']) + [
                    'datetime' => $point->datetime->format(\DateTime::ISO8601)
                ];
        }

        return $pool;
    }
}