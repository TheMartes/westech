<?php declare(strict_types=1);

namespace Westech\Middleware;

use Westech\Errors\UnauthorizedError;
use Westech\ValueObject\EnvVariables;

class Authentication
{
	private static $secret = 'westech';

	public static function validateBearer(string $bearerSecret, ?string $input): bool
	{
		$correct = \crypt(self::$secret, $bearerSecret);
		$result = hash_equals($input, $correct);

		return $result;
	}
}