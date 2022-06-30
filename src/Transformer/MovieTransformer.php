<?php

namespace App\Transformer;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;

class MovieTransformer implements TransformerInterface
{
    private $repository;

    public function __construct(GenreRepository $repository)
    {
        $this->repository = $repository;
    }

    public function arrayToEntity(array $data): object
    {
        $genreNames = explode(', ', $data['Genre']);
        $date = $data['Released'] !== 'N/A' ? $data['Released'] : $data['Year'];

        $movie = (new Movie())
            ->setTitle($data['Title'])
            ->setPoster($data['Poster'])
            ->setCountry($data['Country'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setImdbId($data['imdbID'])
            ->setRated($data['Rated'])
            ->setPrice(5.0)
            ;

        foreach ($genreNames as $name) {
            $genre = $this->repository->findOneBy(['name' => $name]) ?? (new Genre())->setName($name);
            $movie->addGenre($genre);
        }

        return $movie;
    }
}