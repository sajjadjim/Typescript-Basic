// Variable with type
let userName: string = "SAJJAD HOSSAIN Jim";
let age: number = 25;
let isActive: boolean = true;

// Function with parameter and return type
function greet(name: string): string {
    return `Hello my name is, ${name}!`;
}

// Interface code --
interface User {
    name: string;
    age: number;
    isActive: boolean;
}

// Class implementing the interface
class Person implements User {
    constructor(
        public name: string,
        public age: number,
        public isActive: boolean
    ) {}

    displayInfo(): void {
        console.log(`${this.name} is ${this.age} years old and is ${this.isActive ? "active" : "inactive"}.`);
    }
}

// Using the class and function
const user1 = new Person("SAJJAD HOSSAIN Jim", 25, true);
console.log(greet(user1.name));
user1.displayInfo();
