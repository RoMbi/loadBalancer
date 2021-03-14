<?php

namespace App\Component;

class Host implements HostInterface
{
    public function getLoad(): float
    {
        // logic here
        return 0.5;
    }

    public function handleRequest(RequestInterface $request): void
    {
        // logic here
    }
}
