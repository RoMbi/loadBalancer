<?php
namespace App\Service\LoadBalancer;

use App\Component\HostInterface;
use App\Service\LoadBalancer;

class SequentiallyVariant implements LoadBalanceStrategyInterface
{
    /**
     * Handle variant algorithm: pass the requests sequentially in rotation to each of the hosts
     *
     * @param LoadBalancer $loadBalancer
     *
     * @return HostInterface
     */
    public function provideLoadHost(LoadBalancer $loadBalancer): HostInterface
    {
        $hosts = $loadBalancer->getHosts();
        $loadHost = array_shift($hosts);
        $hosts[] = $loadHost;
        $loadBalancer->setHosts($hosts);

        return $loadHost;
    }
}
