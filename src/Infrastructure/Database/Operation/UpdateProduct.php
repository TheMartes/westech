<?php

namespace Westech\Infrastructure\Database\Operation;

use Westech\Domain\Entity\Product;
use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\UpdateProduct as UpdateProductOperation;
use Westech\Infrastructure\Database\Errors\CannotExecuteQuery;

class UpdateProduct implements UpdateProductOperation
{
	public function __construct(private DatabaseConneciton $db)
	{}

	public function execute(Product $product): Product
	{
		$query = "UPDATE products SET name = :name, description = :description, brand = :brand, category = :category, price = :price WHERE id = :id";
		$this->db->getConnection()->beginTransaction();

		try {
			$statement = $this->db->getConnection()->prepare($query);
			$statement->execute([
				':name' => $product->getName(),
				':description' => $product->getDescription(),
				':brand' => $product->getBrand(),
				':category' => $product->getCategory(),
				':price' => $product->getPrice(),
				':id' => $product->getId()
			]);
			$this->db->getConnection()->commit();

			return $product;
		} catch (\PDOException $e) {
			$this->db->getConnection()->rollBack();
			throw new CannotExecuteQuery($e->getMessage());
		}
	}
}