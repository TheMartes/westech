<?php declare(strict_types=1);

namespace Westech\Infrastructure\Database\Operation;

use PDO;
use Westech\Domain\Entity\Product;
use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\GetClosestProduct as GetClosestProductOperation;
use Westech\Infrastructure\Database\Errors\CannotExecuteQuery;

class GetClosestProduct implements GetClosestProductOperation
{
	public function __construct(private DatabaseConneciton $db)
	{}

	public function execute(float $price): Product
	{
		$query = "SELECT * FROM products ORDER BY ABS(price - $price) LIMIT 1";
		$this->db->getConnection()->beginTransaction();

		try {
			$statement = $this->db->getConnection()->prepare($query);
			$statement->execute();
			$this->db->getConnection()->commit();

			$row = $statement->fetch(PDO::FETCH_OBJ);
			return new Product(
				(int) $row->id,
				$row->name,
				$row->description,
				$row->brand,
				$row->category,
				$row->price
			);
		} catch (\PDOException $e) {
			$this->db->getConnection()->rollBack();
			throw new CannotExecuteQuery($e->getMessage());
		}

		return new Product(2, "", "", "", "", 2, "");
	}
}