<?php

namespace App\Service;

use App\Component\RequestInterface;

/**
 * Class RequestInterface
 *
 * @package App\Service
 */
interface LoadInterface
{
    public function handleRequest(RequestInterface $request): void;
}
