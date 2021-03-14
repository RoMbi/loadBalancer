<?php

namespace App\Service\LoadBalancer;

use App\Component\HostInterface;
use App\Service\LoadBalancer;

class ThreeFourthVariant implements LoadBalanceStrategyInterface
{
    public function provideLoadHost(LoadBalancer $loadBalancer): HostInterface
    {
        {
            /** Setting first host as lower load */
            $lowerLoad = [
                'key' => 0,
                'load' => $loadBalancer->getHosts()[0]->getLoad(),
            ];

            foreach ($loadBalancer->getHosts() as $key => $host) {
                if ($host->getLoad() < $loadBalancer->getVariant()->getMaxLoad()) {
                    return $host;
                }

                if ($host->getLoad() < $lowerLoad['load']) {
                    $lowerLoad = [
                        'key' => $key,
                        'load' => $loadBalancer->getHosts()[$key]->getLoad(),
                    ];
                }
            }

            return $loadBalancer->getHosts()[$lowerLoad['key']];
        }
    }
}
