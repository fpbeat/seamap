<?php

namespace leafTracker\Entities;

use \Spot\Entity;

class PolylineEntity extends Entity {

    protected static $table = 'polyline';

    public static function fields() {
        return [
            'id' => ['type' => 'integer', 'autoincrement' => TRUE, 'primary' => TRUE],
            'lat' => ['type' => 'decimal', 'default' => 0],
            'lng' => ['type' => 'decimal', 'default' => 0],
        ];
    }
}