<?php declare(strict_types=1);

namespace Westech\Domain\Interface;

interface DatabaseConneciton
{
    public function connect(): void;
    public function getConnection(): \PDO;
}