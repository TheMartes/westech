<?php declare(strict_types=1);

namespace Westech\Domain\Case;

use Westech\Domain\Entity\Product;
use Westech\Domain\Interface\DatabaseConneciton;
use Westech\Domain\Operation\GetAllProducts;

class GetProductsCase
{
    public function __construct(
			private DatabaseConneciton $databaseConneciton,
			private GetAllProducts $getAllProducts
		)
    {
    }

		/**
		* @return Product[]
	  */
    public function execute(int $offset = 0): string
    {
        return json_encode($this->getAllProducts->execute($offset), JSON_THROW_ON_ERROR);
    }
}