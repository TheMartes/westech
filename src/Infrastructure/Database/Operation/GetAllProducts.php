<?php declare(strict_types=1);

namespace Westech\Infrastructure\Database\Operation;

use PDO;
use Westech\Domain\Entity\Product;
use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\GetAllProducts as OperationGetAllProducts;
use Westech\Infrastructure\Database\Errors\CannotExecuteQuery;

class GetAllProducts implements OperationGetAllProducts
{
	public function __construct(private DatabaseConneciton $db)
	{}

	/**
	 * @param int|null $offset
	 * @return Product[]
	 */
	public function execute(int $offset): array
	{
		$query = "SELECT * FROM products LIMIT 10 OFFSET $offset";
		$this->db->getConnection()->beginTransaction();

		try {
			$statement = $this->db->getConnection()->prepare($query);
			$statement->execute();
			$this->db->getConnection()->commit();

			return $statement->fetchAll(PDO::FETCH_OBJ);
		} catch (\PDOException $e) {
			$this->db->getConnection()->rollBack();
			throw new CannotExecuteQuery($e->getMessage());
		}
	}
}