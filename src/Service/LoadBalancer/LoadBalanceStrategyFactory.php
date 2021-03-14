<?php
namespace App\Service\LoadBalancer;

use App\Dictionary\Variant as VariantDictionary;
use App\Entity\Variant;

class LoadBalanceStrategyFactory
{
    public static function getStrategy(Variant $variant)
    {
        switch ($variant->getId()) {
            case VariantDictionary::SEQUENTIALLY:
                return new SequentiallyVariant();
            case VariantDictionary::LOAD_75_PERCENT:
                return new ThreeFourthVariant();
            default:
                throw new \Exception('Load balancer - incorrect variant.');
        }
    }
}
