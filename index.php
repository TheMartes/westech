<?php declare(strict_types=1);

// I'm using composer so I dont have to use require / require_once
require __DIR__ . '/vendor/autoload.php';

use Westech\Router;

header('Content-Type: application/json');

$env = new \Westech\Service\GetEnvVariables();
$envVariables = $env->fetch();

$requestInfo = new \Westech\ValueObject\RequestInfo(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
    $_SERVER['HTTP_AUTHORIZATION'],
    file_get_contents('php://input')
);

$db = new \Westech\Infrastructure\Database\Connection($envVariables);
$db->connect();

$createProduct = new \Westech\Infrastructure\Database\Operation\CreateProduct($db);
$getAllProducts = new \Westech\Infrastructure\Database\Operation\GetAllProducts($db);
$getClosestProduct = new \Westech\Infrastructure\Database\Operation\GetClosestProduct($db);
$updateProduct = new \Westech\Infrastructure\Database\Operation\UpdateProduct($db);
$deleteProduct = new \Westech\Infrastructure\Database\Operation\DeleteProduct($db);

try {
	$router = new Router($requestInfo, $envVariables->getBearerSecret(), $db, $createProduct, $getAllProducts, $getClosestProduct, $updateProduct, $deleteProduct);
	$router->handleRequest();
} catch (\Exception $e) {
	http_response_code(500);
	echo json_encode(['error' => $e->getMessage()]);
	$db->disconnect();
}

$db->disconnect();
