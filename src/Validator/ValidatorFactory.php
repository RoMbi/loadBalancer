<?php

namespace App\Validator;

use App\Service\LoadBalancer;
use http\Exception\RuntimeException;

/**
 * Class ValidatorFactory
 *
 * @package App\Validator
 */
class ValidatorFactory
{
    public static function getValidator($service): LoadBalancerValidator
    {
        switch (true) {
            case $service instanceof LoadBalancer:
                return new LoadBalancerValidator($service);
            default:
                throw new RuntimeException("Validator not found for class: " . get_class($service));
        }
    }
}
