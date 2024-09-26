<?php declare(strict_types=1);

namespace Westech\ValueObject;

use Westech\Errors\InvalidBodySuppliedError;

class RequestInfo
{
	  private $method;
	  private $uri;
	  private ?string $bearerToken;
	  private $body;

    public function __construct(
        string $method,
        string $uri,
        ?string $authHeader,
        ?string $body
    ) {
				$this->sanitizeInputs($method, $uri, $authHeader, $body);
    }

		private function sanitizeInputs(
			string $method,
			string $uri,
			?string $authHeader,
			?string $body
		): void
		{
			$parsedUrl = parse_url($uri, PHP_URL_PATH);
			$sanitazedUri = explode('/', $parsedUrl);

			$bearer = null;
			if ($authHeader !== null) {
				$bearer = explode(' ', $authHeader)[1];
			}

			$sanitazedBody = [];

			if (isset($body) && $body !== '') {
				try {
					$sanitazedBody = \json_decode(json: $body, associative: true, flags: JSON_THROW_ON_ERROR);
				} catch (\JsonException $e) {
					throw new InvalidBodySuppliedError($e->getMessage());
				}
			}

			$this->method = $method;
			$this->uri = $sanitazedUri;
			$this->bearerToken = $bearer;
			$this->body = $sanitazedBody;
		}

		public function getMethod(): string
		{
			return $this->method;
		}

		public function getUri(): array
		{
			return $this->uri;
		}

		public function getBearerToken(): ?string
		{
			return $this->bearerToken;
		}

		public function getBody(): array
		{
			return $this->body;
		}
}