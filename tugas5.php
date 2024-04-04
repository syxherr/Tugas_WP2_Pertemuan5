<?php


class Book {
    protected $title;
    protected $author;
    protected $year;
    protected $isBorrowed;
    protected static $totalBooks = 0;
  
    public function __construct($title, $author, $year) {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->isBorrowed = false;
        self::$totalBooks++; 
    }


    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getYear() {
        return $this->year;
    }

    public function isBorrowed() {
        return $this->isBorrowed;
    }

    public function borrowBook() {
        $this->isBorrowed = true;
    }

    public function returnBook() {
        $this->isBorrowed = false;
    }

    public static function getTotalBooks() {
        return self::$totalBooks;
    }
}

class ReferenceBook extends Book {
    private $referenceCode;

    public function __construct($title, $author, $year, $referenceCode) {
        parent::__construct($title, $author, $year);
        $this->referenceCode = $referenceCode;
    }

    public function getReferenceCode() {
        return $this->referenceCode;
    }

    public function borrowBook() {
        echo "Buku referensi tidak dapat dipinjam.\n";
    }
}

class Library {
    protected $books;

    public function __construct() {
        $this->books = [];
    }

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function borrowBook($title) {
        foreach ($this->books as $book) {
            if ($book->getTitle() === $title && !$book->isBorrowed()) {
                $book->borrowBook();
                echo "Buku dengan judul '$title' berhasil dipinjam.\n";
                return;
            }
        }
        echo "Buku dengan judul '$title' tidak tersedia atau sudah dipinjam.\n";
    }

    public function returnBook($title) {
        foreach ($this->books as $book) {
            if ($book->getTitle() === $title && $book->isBorrowed()) {
                $book->returnBook();
                echo "Buku dengan judul '$title' berhasil dikembalikan.\n";
                return;
            }
        }
        echo "Buku dengan judul '$title' tidak bisa dikembalikan karena tidak dipinjam atau tidak tersedia.\n";
    }

    public function printAvailableBooks() {
        if (empty($this->books)) {
            echo "Tidak ada buku yang tersedia.\n";
            return;
        }
        echo "Daftar buku yang tersedia:\n";
        foreach ($this->books as $book) {
            if (!$book->isBorrowed()) {
                echo "- {$book->getTitle()} ({$book->getAuthor()}, {$book->getYear()})\n";
            }
        }
    }

    public function addNewBook($title, $author, $year) {
        $newBook = new Book($title, $author, $year);
        $this->books[] = $newBook;
        echo "Buku dengan judul '$title' berhasil ditambahkan ke perpustakaan.\n";
    }
}

function showMenu() {
    echo "Pilih fitur yang ingin digunakan:\n";
    echo "1. Daftar Buku yang Tersedia\n";
    echo "2. Tambah Buku Baru\n";
    echo "3. Pinjam Buku\n";
    echo "4. Kembalikan Buku\n";
    echo "5. Jumlah Buku\n"; 
    echo "Masukkan nomor: ";
}

function selectFeature($choice, $library) {
    switch ($choice) {
        case 1:
            $library->printAvailableBooks();
            break;
        case 2:
            addNewBook($library);
            break;
        case 3:
            borrowBook($library);
            break;
        case 4:
            returnBook($library);
            break;
        case 5:
            echo "Total Buku: " . Book::getTotalBooks() . "\n";
            break;
        default:
            echo "Pilihan tidak valid.\n";
    }
}

function addNewBook($library) {
    echo "Masukkan detail buku baru:\n";
    echo "Judul: ";
    $title = readline();
    echo "Penulis: ";
    $author = readline();
    echo "Tahun Terbit: ";
    $year = readline();
    $library->addNewBook($title, $author, $year);
}

function borrowBook($library) {
    echo "Masukkan judul buku yang ingin dipinjam: ";
    $title = readline();
    $library->borrowBook($title);
}

function returnBook($library) {
    echo "Masukkan judul buku yang ingin dikembalikan: ";
    $title = readline();
    $library->returnBook($title);
}

$library = new Library();

while (true) {
    showMenu();
    $choice = (int) readline();

    selectFeature($choice, $library);

    echo "\nApakah Anda ingin melanjutkan? (Y/N): ";
    $continue = strtolower(readline());
    if ($continue !== 'y') {
        echo "Terima kasih telah menggunakan layanan kami.\n";
        break;
    }
}
?>