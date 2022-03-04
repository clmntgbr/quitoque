<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookAuthor;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\BookType;

class BookController extends AbstractController
{
    /**
     * @Route("/books", name="app_books")
     */
    public function books(EntityManagerInterface $em): Response
    {
        return $this->render('app/books.html.twig', [
            'books' => $em->getRepository(Book::class)->findAll(),
        ]);
    }

    /**
     * @Route("/book/{id}", name="app_book_id")
     * @ParamConverter("book", class=Book::class, options={"mapping": {"id": "id"}})
     */
    public function bookId(EntityManagerInterface $em, Book $book): Response
    {
        return $this->render('app/book_id.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/book_type/{id}", name="app_book_type")
     * @ParamConverter("bookType", class=BookType::class, options={"mapping": {"id": "id"}})
     */
    public function bookType(EntityManagerInterface $em, BookType $bookType): Response
    {
        return $this->render('app/book_type.html.twig', [
            'books' => $bookType->getBooks(),
        ]);
    }

    /**
     * @Route("/book_release/{date}", name="app_book_release")
     */
    public function bookRelease(EntityManagerInterface $em, string $date): Response
    {
        return $this->render('app/book_release.html.twig', [
            'books' => $em->getRepository(Book::class)->findBy(['releaseDate' => $date]),
        ]);
    }

    /**
     * @Route("/book_author/{id}", name="app_book_author")
     * @ParamConverter("bookAuthor", class=BookAuthor::class, options={"mapping": {"id": "id"}})
     */
    public function bookAuthor(EntityManagerInterface $em, BookAuthor $bookAuthor): Response
    {
        return $this->render('app/book_author.html.twig', [
            'books' => $bookAuthor->getBooks(),
        ]);
    }
}
