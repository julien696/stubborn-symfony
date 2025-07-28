<?php

namespace App\Form\Model;

use App\Entity\SweatshirtSize;

class AddToCartData
{
    public ?SweatshirtSize $sweatshirtSize = null;
    public int $quantity = 1;
}