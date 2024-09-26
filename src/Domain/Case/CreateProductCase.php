<?php declare(strict_types=1);

namespace Westech\Domain\Case;

use Westech\Domain\Entity\Product;
use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\CreateProduct;

class CreateProductCase
{
	public function __construct(
			private DatabaseConneciton $databaseConneciton,
			private CreateProduct $createProduct
		)
    {
    }

    public function execute(string $name, ?string $description, string $brand, string $category, float $price): string
    {
				$product = new Product(0, $name, $description, $brand, $category, $price);
        $newProduct = $this->createProduct->execute($product);

        return json_encode([
            'id' => $newProduct->getId(),
            'name' => $newProduct->getName(),
            'description' => $newProduct->getDescription(),
            'brand' => $newProduct->getBrand(),
            'category' => $newProduct->getCategory(),
            'price' => $newProduct->getPrice()
        ], JSON_THROW_ON_ERROR);
    }
}