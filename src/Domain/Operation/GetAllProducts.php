<?php declare(strict_types=1);

namespace Westech\Domain\Operation;

interface GetAllProducts
{
	public function execute(int $offset): array;
}