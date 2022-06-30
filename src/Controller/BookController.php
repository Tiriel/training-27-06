<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        if (!$this->isGranted('BOOK_EDIT', $book)) {
            // ...
        }

        return $this->render('book/index.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($book);
        }

        return $this->renderForm('book/new.html.twig', [
            'book_form' => $form,
        ]);
    }
}
