<?php
namespace App\Validator;

use App\Service\LoadBalancer;
use http\Exception\RuntimeException;

/**
 * Class LoadBalancerValidator
 */
class LoadBalancerValidator implements ValidatorInterface
{
    /**
     * @var LoadBalancer
     */
    private LoadBalancer $loadBalancer;

    public function __construct(LoadBalancer $loadBalancer) {
        $this->loadBalancer = $loadBalancer;
    }

    /**
     * Validation method
     *
     * @throws RuntimeException
     */
    public function validate(): void
    {
        /** validate hosts list - check if it's filled with any host */
        if (!$this->loadBalancer->getHosts()) {
            throw new RuntimeException('Load balancer - no hosts to load');
        }
    }
}
