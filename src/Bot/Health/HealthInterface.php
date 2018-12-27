<?php

namespace App\Bot\Health;


interface HealthInterface
{
    /**
     * Perform a health check
     *
     * @return bool
     */
    public function check():bool;
}