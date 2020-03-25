<?php

namespace Domain\Entity;

class Product
{
    var $code;
    var $name;
    var $priceCents;

    /**
     * @param string $code Product code
     * @param string $name Product name
     * @param int $priceCents Price in cents
     */
    public function __construct(string $code, string $name, int $priceCents)
    {
        $this->code = $code;
        $this->name = $name;
        $this->priceCents = $priceCents;
    }
}
