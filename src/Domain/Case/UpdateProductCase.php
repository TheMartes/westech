<?php declare(strict_types=1);

namespace Westech\Domain\Case;

use Westech\Domain\Entity\Product;
use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\UpdateProduct;

class UpdateProductCase
{
	public function __construct(
			private DatabaseConneciton $databaseConneciton,
			private UpdateProduct $updateProduct
		)
    {
    }

    public function execute(int $id, string $name, ?string $description, string $brand, string $category, float $price): string
    {
				$product = new Product($id, $name, $description, $brand, $category, $price);
        $updatedProduct = $this->updateProduct->execute($product);
        return json_encode([
            'id' => $updatedProduct->getId(),
            'name' => $updatedProduct->getName(),
            'description' => $updatedProduct->getDescription(),
            'brand' => $updatedProduct->getBrand(),
            'category' => $updatedProduct->getCategory(),
            'price' => $updatedProduct->getPrice()
        ], JSON_THROW_ON_ERROR);
    }
}