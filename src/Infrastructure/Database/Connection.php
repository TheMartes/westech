<?php declare(strict_types=1);

namespace Westech\Infrastructure\Database;

use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Infrastructure\Database\Errors\CannotEstablishMySQLConnection;
use Westech\ValueObject\EnvVariables;

class Connection implements DatabaseConneciton
{
		private ?\PDO $pdo = null;

    public function __construct(private EnvVariables $envVariables)
    {}

    public function connect(): void
    {
				if ($this->pdo !== null) {
					return;
				}

        try {
		        $dsn = \sprintf("mysql:host=%s;port=%s;dbname=%s", $this->envVariables->getHost(), $this->envVariables->getPort(), $this->envVariables->getName());
            $pdo = new \PDO($dsn, $this->envVariables->getName(), $this->envVariables->getPass());
            $this->pdo = $pdo;
        } catch (\PDOException $e) {
            throw new CannotEstablishMySQLConnection($e->getMessage());
        }
    }

		public function getConnection(): \PDO
		{
			return $this->pdo;
		}

		public function disconnect(): void
		{
			$this->pdo = null;
		}
}