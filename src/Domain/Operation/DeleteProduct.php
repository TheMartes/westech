<?php declare(strict_types=1);

namespace Westech\Domain\Operation;

interface DeleteProduct
{
	public function execute(int $id): void;
}