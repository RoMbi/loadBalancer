<?php

namespace App\Component;

interface HostInterface
{
    public function getLoad(): float;

    public function handleRequest(RequestInterface $request): void;
}
