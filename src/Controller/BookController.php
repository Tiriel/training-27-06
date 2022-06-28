<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book", name="app_book_")
 */
class BookController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'Index',
        ]);
    }

    /**
     * @Route("/{page<\d+>?1}", name="paginated")
     */
    public function paginated(Request $request): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'Paginated',
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="details")
     */
    public function details(int $id, BookRepository $repository): Response
    {
        $book = $repository->find($id);

        return $this->render('book/index.html.twig', [
            'book' => $book,
        ]);
    }
}
