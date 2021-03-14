<?php

namespace App\Service;

use App\Component\HostInterface;
use App\Component\RequestInterface;
use App\Entity\Variant;
use App\Service\LoadBalancer\LoadBalanceStrategyFactory;
use App\Service\LoadBalancer\LoadBalanceStrategyInterface;
use App\Validator\LoadBalancerValidator;
use App\Validator\ValidatorFactory;

/**
 * A LoadBalancer class to handle request on given host instances with specified variant
 */
class LoadBalancer implements LoadInterface
{
    /**
     * @var HostInterface[]
     */
    private array $hosts;

    private Variant $variant;

    private LoadBalancerValidator $validator;

    private LoadBalanceStrategyInterface $loadStrategy;

    /**
     * LoadBalancer constructor.
     *
     * @param array $hosts
     * @param Variant $variant
     *
     * @throws \Exception
     */
    public function __construct(array $hosts, Variant $variant)
    {
        $this->hosts = $hosts;
        $this->variant = $variant;
        $this->validator = ValidatorFactory::getValidator($this);
        $this->loadStrategy = LoadBalanceStrategyFactory::getStrategy($variant);
    }

    /**
     * Method used to handle given Request
     *
     * @param RequestInterface $request
     *
     * @throws \Exception
     */
    public function handleRequest(RequestInterface $request): void
    {
        try {
            $this->validator->validate();
            $this->loadStrategy->provideLoadHost($this)->handleRequest($request);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getHosts(): array
    {
        return $this->hosts;
    }

    public function setHosts(array $hosts): void
    {
        $this->hosts = $hosts;
    }

    public function getVariant(): Variant
    {
        return $this->variant;
    }
}