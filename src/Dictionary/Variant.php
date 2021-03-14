<?php

namespace App\Dictionary;

/**
 * Dictionary class with load balancer variants
 */
class Variant
{
    const SEQUENTIALLY = 1;
    const LOAD_75_PERCENT = 2;
}