

// Enum for Book Genres
enum Genre {
    Fiction = "Fiction",
    NonFiction = "Non-Fiction",
    Science = "Science",
    History = "History",
    Fantasy = "Fantasy"
}

// Interface for a Book
interface Book {
    id: number;
    title: string;
    author: string;
    genre: Genre;
    available: boolean;
}

// Interface for a User
interface User {
    id: number;
    name: string;
    borrowedBooks: Book[];
}

// Generic Repository for managing collections
class Repository<T extends { id: number }> {
    private items: T[] = [];

    add(item: T): void {
        this.items.push(item);
    }

    getById(id: number): T | undefined {
        return this.items.find(item => item.id === id);
    }

    getAll(): T[] {
        return [...this.items];
    }

    removeById(id: number): void {
        this.items = this.items.filter(item => item.id !== id);
    }
}

// Library class to manage books and users
class Library {
    private books = new Repository<Book>();
    private users = new Repository<User>();

    addBook(book: Book): void {
        this.books.add(book);
    }

    addUser(user: User): void {
        this.users.add(user);
    }

    borrowBook(userId: number, bookId: number): string {
        const user = this.users.getById(userId);
        const book = this.books.getById(bookId);

        if (!user) return "User not found.";
        if (!book) return "Book not found.";
        if (!book.available) return "Book is not available.";

        book.available = false;
        user.borrowedBooks.push(book);
        return `${user.name} borrowed "${book.title}".`;
    }

    returnBook(userId: number, bookId: number): string {
        const user = this.users.getById(userId);
        const book = this.books.getById(bookId);

        if (!user) return "User not found.";
        if (!book) return "Book not found.";

        const index = user.borrowedBooks.findIndex(b => b.id === bookId);
        if (index === -1) return "Book not borrowed by user.";

        user.borrowedBooks.splice(index, 1);
        book.available = true;
        return `${user.name} returned "${book.title}".`;
    }

    listAvailableBooks(): Book[] {
        return this.books.getAll().filter(book => book.available);
    }

    listUserBorrowedBooks(userId: number): Book[] {
        const user = this.users.getById(userId);
        return user ? user.borrowedBooks : [];
    }
}

// Example usage
const library = new Library();

library.addBook({ id: 1, title: "1984", author: "George Orwell", genre: Genre.Fiction, available: true });
library.addBook({ id: 2, title: "A Brief History of Time", author: "Stephen Hawking", genre: Genre.Science, available: true });
library.addBook({ id: 3, title: "The Hobbit", author: "J.R.R. Tolkien", genre: Genre.Fantasy, available: true });

library.addUser({ id: 1, name: "Sajjad Hossain JIM", borrowedBooks: [] });
library.addUser({ id: 2, name: "Salma Labanna", borrowedBooks: [] });

console.log(library.borrowBook(1, 1)); // Alice borrows "1984"
console.log(library.borrowBook(2, 2)); // Bob borrows "A Brief History of Time"
console.log(library.borrowBook(1, 2)); // Book is not available

console.log("Available Books:", library.listAvailableBooks());
console.log("Alice's Books:", library.listUserBorrowedBooks(1));

console.log(library.returnBook(1, 1)); // Alice returns "1984"
console.log("Available Books after return:", library.listAvailableBooks());