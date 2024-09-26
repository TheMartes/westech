<?php declare(strict_types=1);

namespace Westech\Service;

class GetRequestInfo
{
    public function getRequestInfo(): array
    {
        $requestInfo = [
            'method' => $_SERVER['REQUEST_METHOD'],
            'uri' => $_SERVER['REQUEST_URI'],
            'headers' => $_SERVER,
            'body' => file_get_contents('php://input')
        ];

        return $requestInfo;
    }
}