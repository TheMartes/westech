<?php declare(strict_types=1);

namespace Westech\Domain\Case;

use Westech\Domain\Entity\Product;
use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\DeleteProduct;

class DeleteProductCase
{
	public function __construct(
			private DatabaseConneciton $databaseConneciton,
			private DeleteProduct $deleteProduct
		)
    {
    }

    public function execute(int $id): void
    {
        $this->deleteProduct->execute($id);
    }
}