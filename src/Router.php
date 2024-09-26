<?php

namespace Westech;

use Westech\Domain\Case\ClosestProductCase;
use Westech\Domain\Case\CreateProductCase;
use Westech\Domain\Case\DeleteProductCase;
use Westech\Domain\Case\GetProductsCase;
use Westech\Domain\Case\UpdateProductCase;
use Westech\Infrastructure\Database\Connection;
use Westech\Infrastructure\Database\Operation\CreateProduct;
use Westech\Infrastructure\Database\Operation\DeleteProduct;
use Westech\Infrastructure\Database\Operation\GetAllProducts;
use Westech\Infrastructure\Database\Operation\GetClosestProduct;
use Westech\Infrastructure\Database\Operation\UpdateProduct;
use Westech\ValueObject\RequestInfo;

class Router
{
	public function __construct(
		private RequestInfo $requestInfo,
		private	Connection $db,
		private CreateProduct $createProduct,
		private GetAllProducts $getAllProducts,
		private GetClosestProduct $getClosestProduct,
		private UpdateProduct $updateProduct,
		private DeleteProduct $deleteProduct
	)
	{}

	public function handleRequest(): void
	{
		if ($this->requestInfo->getUri()[1] == 'products') {
			if ($this->requestInfo->getUri()[2] == 'matchClosest') {
				$this->handleMatchClosest($this->requestInfo->getMethod());
			  return;
			}

			$this->handleProducts($this->requestInfo->getMethod());
		} else {
			http_response_code(404);
		}
	}

	private function handleProducts($method)
	{
		switch ($method) {
			case 'GET':
				$getProductsCase = new GetProductsCase($this->db, $this->getAllProducts);
				$offset = $_GET['offset'] ?? 0;

				http_response_code(200);
				header('Content-Type: application/json');

				echo $getProductsCase->execute($offset);
				break;
			case 'POST':
				$requestValid = $this->validateRequest(['name', 'description', 'brand', 'category', 'price']);
				if ($requestValid) {
					$createProductCase = new CreateProductCase($this->db, $this->createProduct);

					http_response_code(200);
					header('Content-Type: application/json');

					echo $createProductCase->execute(
						$this->requestInfo->getBody()['name'],
						$this->requestInfo->getBody()['description'],
						$this->requestInfo->getBody()['brand'],
						$this->requestInfo->getBody()['category'],
						$this->requestInfo->getBody()['price']
					);
				}
				break;

			case 'PATCH':
				$requestValid = $this->validateRequest(['id', 'name', 'description', 'brand', 'category', 'price']);
				if ($requestValid) {
					$updateProductCase = new UpdateProductCase($this->db, $this->updateProduct);

					http_response_code(200);
					header('Content-Type: application/json');

					echo $updateProductCase->execute(
						$this->requestInfo->getBody()['id'],
						$this->requestInfo->getBody()['name'],
						$this->requestInfo->getBody()['description'],
						$this->requestInfo->getBody()['brand'],
						$this->requestInfo->getBody()['category'],
						$this->requestInfo->getBody()['price']
					);
				}
				break;

			case 'DELETE':
				$requestValid = $this->validateRequest(['id']);
				if ($requestValid) {
					$deleteProductCase = new DeleteProductCase($this->db, $this->deleteProduct);
					$deleteProductCase->execute($this->requestInfo->getBody()['id']);
					http_response_code(204);
				}
				break;

			default:
				http_response_code(405);
				echo json_encode(['error' => 'Method not allowed']);
				break;
		}
	}

	private function handleMatchClosest($method)
	{
		switch ($method) {
			case 'GET':
				$getClosestProduct = new ClosestProductCase($this->db, $this->getClosestProduct);

				http_response_code(200);
				header('Content-Type: application/json');

				echo $getClosestProduct->execute($this->requestInfo->getBody()['price']);
				break;
			default:
				http_response_code(405);
				echo json_encode(['error' => 'Method not allowed']);
				break;
		}
	}

	private function validateRequest(array $bodyEntries): bool
	{
		foreach ($bodyEntries as $value) {
			if (!isset($this->requestInfo->getBody()[$value])) {
				http_response_code(400);
				echo json_encode(['error' => "Missing field '$value'"]);

				return false;
			}
		}

		return true;
	}
}