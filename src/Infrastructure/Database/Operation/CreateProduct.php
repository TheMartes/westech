<?php declare(strict_types=1);

namespace Westech\Infrastructure\Database\Operation;

use Westech\Domain\Entity\Product;
use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\CreateProduct as CreateProductOperation;
use Westech\Infrastructure\Database\Errors\CannotExecuteQuery;

class CreateProduct implements CreateProductOperation
{
	public function __construct(private DatabaseConneciton $db)
	{}

	public function execute(Product $product): Product
	{
		$query = "INSERT INTO products (name, description, brand, category, price) VALUES (:name, :description, :brand, :category, :price)";
		$this->db->getConnection()->beginTransaction();

		try {
			$statement = $this->db->getConnection()->prepare($query);
			$statement->execute([
				':name' => $product->getName(),
				':description' => $product->getDescription(),
				':brand' => $product->getBrand(),
				':category' => $product->getCategory(),
				':price' => $product->getPrice()
			]);
			$this->db->getConnection()->commit();

			$createdProduct = new Product(
				(int) $this->db->getConnection()->lastInsertId(),
				$product->getName(),
				$product->getDescription(),
				$product->getBrand(),
				$product->getCategory(),
				$product->getPrice()
			);

			return $createdProduct;
		} catch (\PDOException $e) {
			$this->db->getConnection()->rollBack();
			throw new CannotExecuteQuery($e->getMessage());
		}
	}
}