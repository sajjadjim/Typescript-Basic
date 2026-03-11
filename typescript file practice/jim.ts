// jim.ts
// A demonstration of various TypeScript features in a single file

// 1. Basic Types
let id: number = 101;
let username: string = "jim";
let isActive: boolean = true;
let tags: string[] = ["typescript", "javascript", "nodejs"];
let scores: Array<number> = [90, 85, 88];

// 2. Tuple
let userTuple: [number, string, boolean] = [1, "jim", true];

// 3. Enum
enum UserRole {
    Admin,
    Editor,
    Viewer,
}
let myRole: UserRole = UserRole.Editor;

// 4. Any and Unknown
let randomValue: any = "Could be anything";
let unknownValue: unknown = 42;

// 5. Functions
function greet(name: string): string {
    return `Hello, ${name}!`;
}

function add(a: number, b: number): number {
    return a + b;
}

function logMessage(message: string): void {
    console.log(message);
}

// 6. Interfaces
interface User {
    id: number;
    name: string;
    email?: string; // optional property
    role: UserRole;
}

const user1: User = {
    id: 1,
    name: "Jim",
    role: UserRole.Admin,
};

// 7. Type Aliases
type Point = {
    x: number;
    y: number;
};

const origin: Point = { x: 0, y: 0 };

// 8. Classes and Inheritance
class Animal {
    constructor(public name: string) {}
    move(distance: number): void {
        console.log(`${this.name} moved ${distance}m.`);
    }
}

class Dog extends Animal {
    bark(): void {
        console.log("Woof! Woof!");
    }
}

const dog = new Dog("Buddy");
dog.bark();
dog.move(10);

// 9. Generics
function identity<T>(arg: T): T {
    return arg;
}

let output1 = identity<string>("myString");
let output2 = identity<number>(100);

// 10. Generic Interface
interface ApiResponse<T> {
    status: number;
    data: T;
}

const response: ApiResponse<User> = {
    status: 200,
    data: user1,
};

// 11. Union and Intersection Types
type StringOrNumber = string | number;
let value: StringOrNumber = "hello";
value = 123;

type Employee = {
    employeeId: number;
};

type Manager = User & Employee;

const manager: Manager = {
    id: 2,
    name: "Alice",
    role: UserRole.Editor,
    employeeId: 1001,
};

// 12. Type Assertions
let someValue: any = "This is a string";
let strLength: number = (someValue as string).length;

// 13. Namespaces
namespace MathUtils {
    export function square(x: number): number {
        return x * x;
    }
}

let squared = MathUtils.square(5);

// 14. Modules (export/import example)
// export function exportedFunction() {}

// 15. Decorators (experimental)
function logClass(target: Function) {
    console.log(`Class decorated: ${target.name}`);
}

@logClass
class Car {
    constructor(public brand: string) {}
}

// 16. Utility Types
type ReadonlyUser = Readonly<User>;
type PartialUser = Partial<User>;
type PickUser = Pick<User, "id" | "name">;

// 17. Async/Await and Promises
async function fetchData(): Promise<string> {
    return new Promise((resolve) => setTimeout(() => resolve("Data loaded"), 1000));
}

fetchData().then(console.log);

// 18. Optional Chaining and Nullish Coalescing
const userEmail = user1.email?.toLowerCase() ?? "No email provided";

// 19. Mapped Types
type UserKeys = keyof User;
type UserMap = {
    [K in UserKeys]: User[K];
};

// 20. Literal Types
type Direction = "up" | "down" | "left" | "right";
let moveDirection: Direction = "up";

// 21. Never Type
function throwError(message: string): never {
    throw new Error(message);
}

// 22. Custom Type Guards
function isUser(obj: any): obj is User {
    return obj && typeof obj.id === "number" && typeof obj.name === "string";
}

// 23. Index Signatures
interface Dictionary {
    [key: string]: string;
}

const dict: Dictionary = {
    hello: "world",
    foo: "bar",
};

// 24. Recursive Types
type Json = string | number | boolean | null | Json[] | { [key: string]: Json };

// 25. Exhaustive Checks with 'never'
function handleRole(role: UserRole) {
    switch (role) {
        case UserRole.Admin:
            return "Admin";
        case UserRole.Editor:
            return "Editor";
        case UserRole.Viewer:
            return "Viewer";
        default:
            const _exhaustiveCheck: never = role;
            return _exhaustiveCheck;
    }
}

// End of big TypeScript file example