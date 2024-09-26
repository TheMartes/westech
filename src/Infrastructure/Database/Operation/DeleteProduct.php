<?php declare(strict_types=1);

namespace Westech\Infrastructure\Database\Operation;

use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\DeleteProduct as DeleteProductOperation;
use Westech\Infrastructure\Database\Errors\CannotExecuteQuery;

class DeleteProduct implements DeleteProductOperation
{
	public function __construct(private DatabaseConneciton $db)
	{}

	public function execute(int $id): void
	{
		$query = "DELETE FROM products WHERE id = :id";
		$this->db->getConnection()->beginTransaction();

		try {
			$statement = $this->db->getConnection()->prepare($query);
			$statement->execute([
				':id' => $id
			]);
			$this->db->getConnection()->commit();
		} catch (\PDOException $e) {
			$this->db->getConnection()->rollBack();
			throw new CannotExecuteQuery($e->getMessage());
		}
	}
}