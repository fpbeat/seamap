<?php

namespace leafTracker\Entities;

use \Spot\Entity;

class PointEntity extends Entity {

    protected static $table = 'points';

    public static function fields() {
        return [
            'id' => ['type' => 'integer', 'autoincrement' => TRUE, 'primary' => TRUE],
            'datetime' => ['type' => 'datetime', 'value' => new \DateTime()],
            'lat' => ['type' => 'decimal', 'default' => 0],
            'lng' => ['type' => 'decimal', 'default' => 0],
            'message' => ['type' => 'text']
        ];
    }
}