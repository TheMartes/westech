<?php declare(strict_types=1);

namespace Westech\Domain\Operation;

use Westech\Domain\Entity\Product;

interface CreateProduct
{
	public function execute(Product $product): Product;
}