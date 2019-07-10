<?php

namespace leafTracker\Repositories;

use leafTracker\Entities\PolylineEntity;
use leafTracker\Repositories\Contracts\PolylineInterface;
use leafTracker\Helpers\Arr;
use Spot\Locator;

class PolylineEntityRepository implements PolylineInterface {

    private $entity;

    public function __construct(PolylineEntity $entity, Locator $locator) {
        $this->entity = $locator->mapper(get_class($entity));
    }

    public function getData() {
        $pool = [];

        foreach ($this->entity->select()->order(['id' => 'ASC']) as $point) {
            $pool[] = Arr::extract($point->toArray(), ['lat', 'lng']);
        }

        return $pool;
    }
}