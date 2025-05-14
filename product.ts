// Interface for a Product
interface Product {
    id: number;
    name: string;
    price: number;
    inStock: boolean;
}

// Class implementing the Product interface
class StoreItem implements Product {
    constructor(
        public id: number,
        public name: string,
        public price: number,
        public inStock: boolean
    ) {}

    displayDetails(): void {
        console.log(`Product ID: ${this.id}`);
        console.log(`Name: ${this.name}`);
        console.log(`Price: $${this.price}`);
        console.log(`Availability: ${this.inStock ? "In Stock" : "Out of Stock"}`);
    }
}

// Function to calculate the total price of multiple products
function calculateTotal(products: Product[]): number {
    return products.reduce((total, product) => total + product.price, 0);
}

// Using the class and function
const item1 = new StoreItem(1, "Laptop", 1200, true);
const item2 = new StoreItem(2, "Mouse", 25, true);
const item3 = new StoreItem(3, "Keyboard", 45, false);

item1.displayDetails();
item2.displayDetails();
item3.displayDetails();

const totalPrice = calculateTotal([item1, item2, item3]);
console.log(`Total Price: $${totalPrice}`);