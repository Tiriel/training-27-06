<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Event\MovieEvent;
use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use App\Security\Voter\MovieVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/movie", name="app_movie_")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    /**
     * @Route("/{title}", name="details", methods={"GET"})
     */
    public function details(string $title, MovieProvider $provider, EventDispatcherInterface $dispatcher): Response
    {
        $movie = $provider->getMovieByTitle($title);

        if (!$this->isGranted(MovieVoter::VIEW, $movie)) {
            $dispatcher->dispatch(new MovieEvent($movie), MovieEvent::UNDERAGE);

            throw new AccessDeniedException();
        }

        return $this->render('movie/details.html.twig', [
            'movie' => $movie
        ]);
    }
}
