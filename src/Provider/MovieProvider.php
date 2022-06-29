<?php

namespace App\Provider;

use App\Consumer\OMDbApiConsumer;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Transformer\MovieTransformer;

class MovieProvider
{

    private MovieRepository $repository;

    private OMDbApiConsumer $consumer;

    private MovieTransformer $transformer;

    public function __construct(MovieRepository $repository, OMDbApiConsumer $consumer, MovieTransformer $transformer)
    {
        $this->repository = $repository;
        $this->consumer = $consumer;
        $this->transformer = $transformer;
    }

    public function getMovieByTitle(string $title): Movie
    {
        if ($movie = $this->repository->findOneByTitle($title)) {
            return $movie;
        }

        /** @var Movie $movie */
        $movie = $this->transformer->arrayToEntity(
            $this->consumer->getMovieByTitle($title)
        );

        $this->repository->add($movie, true);

        return $movie;
    }
}