<?php

namespace Domain\Entity;

class Product
{
    /** @var string code Product code */
    var $code;

    /** @var string name Product name*/
    var $name;

    /** @var int priceCents Price in cents */
    var $priceCents;

    /**
     * @param string $code
     * @param string $name
     * @param int $priceCents
     */
    public function __construct(string $code, string $name, int $priceCents)
    {
        $this->code = $code;
        $this->name = $name;
        $this->priceCents = $priceCents;
    }
}
