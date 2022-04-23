<?php

declare(strict_types=1);

namespace App\MyTaggedServices;

use App\DependencyInjection\TaggedServicesInterface;

class ChainService
{
    public function __construct(private TaggedServicesInterface $appMyTagServices)
    {
    }

    public function doStuff()
    {
        foreach ($this->appMyTagServices as $service) {
            var_dump($service::class);
        }
    }
}