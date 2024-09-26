<?php declare(strict_types=1);

namespace Westech\Service;

use Westech\Errors\MisssingEnvVariable;
use Westech\ValueObject\EnvVariables;

class GetEnvVariables
{
    public function fetch(): EnvVariables
    {
        $envVariables = [
            'DB_HOST' => $_ENV['DB_HOST'],
            'DB_USER' => $_ENV['DB_USER'],
            'DB_PASS' => $_ENV['DB_PASS'],
            'DB_NAME' => $_ENV['DB_NAME'],
            'DB_PORT' => $_ENV['DB_PORT'],
						'BEARER_SECRET' => $_ENV['BEARER_SECRET']
        ];

		    foreach ($envVariables as $key => $value) {
			    if ($value === null) {
				    throw new MisssingEnvVariable("Missing env variable: $key");
			    }
		    }

        return new EnvVariables(
					$envVariables['DB_HOST'],
					$envVariables['DB_USER'],
					$envVariables['DB_PASS'],
					$envVariables['DB_NAME'],
					$envVariables['DB_PORT'],
					$envVariables['BEARER_SECRET']
				);
	}
}