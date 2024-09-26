<?php declare(strict_types=1);

namespace Westech\ValueObject;

class EnvVariables
{
    public function __construct(
        private string $host,
        private string $user,
        private string $pass,
        private string $name,
        private string $port
    )
    {}

    public function getHost(): string
    {
        return $this->host;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPort(): string
    {
        return $this->port;
    }
}