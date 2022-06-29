<?php

namespace App\Consumer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OMDbApiConsumer
{
    public const TYPE_ID = 'i';
    public const TYPE_TITLE = 't';

    private $omdbClient;

    public function __construct(HttpClientInterface $omdbClient)
    {
        $this->omdbClient = $omdbClient;
    }

    public function getMovieById(string $id): array
    {
        return $this->getOneMovie(self::TYPE_ID, $id);
    }

    public function getMovieByTitle(string $title): array
    {
        return $this->getOneMovie(self::TYPE_TITLE, $title);
    }

    private function getOneMovie(string $fetch, string $value): array
    {
        if (!in_array($fetch, [self::TYPE_ID, self::TYPE_TITLE])) {
            throw new \RuntimeException(sprintf("Unknown fetch type: %s", $fetch));
        }

        $data = $this->omdbClient->request(
            Request::METHOD_GET,
            '',
            [
                'query' => [$fetch => $value],
            ]
        )->toArray();

        if (array_key_exists('Response', $data) && $data['Response'] === 'False') {
            throw new NotFoundHttpException(sprintf("Movie %s was not found.", $value));
        }

        return $data;
    }
}