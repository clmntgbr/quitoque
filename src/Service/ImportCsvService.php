<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\BookAuthor;
use App\Entity\BookType;
use Doctrine\ORM\EntityManagerInterface;

class ImportCsvService
{
    const CSV_CUSTOMER_FILENAME = 'bibliotheque.csv';
    const HEADER_CSV = ["titre", "auteur", "année de publication", "genre\r\n"];

    /** @var CsvService */
    private $csvService;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(CsvService $csvService, EntityManagerInterface $em)
    {
        $this->csvService = $csvService;
        $this->em = $em;
    }

    public function start()
    {
        $handle = $this->csvService->open(CsvService::CSV_DIRECTORY, self::CSV_CUSTOMER_FILENAME);

        if(false === $this->headerValidation($handle)) {
            throw new \Exception('customer csv header is not correct.');
        }

        while (false !== ($rawString = fgets($handle))) {
            $rawString = str_replace("\n", '', $rawString);
            $data = explode(';', $rawString);
            $this->createBook($data);
        }
    }

    private function createBook(array $data)
    {
        $book = $this->em->getRepository(Book::class)->findOneBy(['title' => $data[0]]);

        if ($book instanceof Book) {
            return;
        }

        $bookAuthor = $this->em->getRepository(BookAuthor::class)->findOneBy(['name' => $data[1]]);

        if (null === $bookAuthor) {
            $bookAuthor = $this->createBookAuthor($data[1]);
        }

        $bookType = $this->em->getRepository(BookType::class)->findOneBy(['name' => trim($data[3])]);

        if (null === $bookType) {
            $bookType = $this->createBookType(trim($data[3]));
        }

        $book = new Book();
        $book
            ->setTitle($data[0])
            ->setBookAuthor($bookAuthor)
            ->setBookType($bookType)
            ->setReleaseDate($data[2])
        ;

        $this->em->persist($book);
        $this->em->flush();
    }

    private function createBookAuthor(string $name): BookAuthor
    {
        $bookAuthor = new BookAuthor();
        $bookAuthor->setName($name);
        $this->em->persist($bookAuthor);
        $this->em->flush();

        return $bookAuthor;
    }

    private function createBookType(string $name): BookType
    {
        $bookType = new BookType();
        $bookType->setName($name);
        $this->em->persist($bookType);
        $this->em->flush();

        return $bookType;
    }

    private function headerValidation($handle)
    {
        $header = fgets($handle);
        foreach (explode(';', $header) as $value => $data) {
            if ($data !== self::HEADER_CSV[$value]) {
                return false;
            }
        }
        return true;
    }
}