<?php declare(strict_types=1);

namespace Westech\Domain\Operation;

use Westech\Domain\Entity\Product;

interface GetClosestProduct
{
	public function execute(float $price): Product;
}