<?php declare(strict_types=1);

namespace Westech\Domain\Case;

use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\GetClosestProduct;

class ClosestProductCase
{
	public function __construct(
			private DatabaseConneciton $databaseConneciton,
			private GetClosestProduct $getClosestProduct
		)
    {
    }

    public function execute(float $price): string
    {
        $closestProduct = $this->getClosestProduct->execute($price);

        return json_encode([
            'id' => $closestProduct->getId(),
            'name' => $closestProduct->getName(),
            'description' => $closestProduct->getDescription(),
            'brand' => $closestProduct->getBrand(),
            'category' => $closestProduct->getCategory(),
            'price' => $closestProduct->getPrice()
        ], JSON_THROW_ON_ERROR);
    }
}