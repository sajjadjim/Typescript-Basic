/**
 * MEDIUM LEVEL TYPESCRIPT EXAMPLE
 * Scenario: A Generic In-Memory Data Manager
 */

// 1. Define a Union Type for specific status states
type TaskStatus = 'pending' | 'in-progress' | 'completed';

// 2. Define the shape of our Task data
interface ITask {
  id: number;
  title: string;
  description?: string; // Optional property
  status: TaskStatus;
  createdAt: Date;
}

// 3. Define a Constraint Interface
// Any item stored in our Manager MUST have an 'id'
interface HasID {
  id: number;
}

/**
 * 4. Create a Generic Class
 * <T extends HasID> ensures we can only manage objects that have an 'id'.
 */
class DataManager<T extends HasID> {
  // private variable to store state
  private items: T[] = [];

  constructor(initialItems: T[] = []) {
    this.items = initialItems;
  }

  // Method to add an item
  add(item: T): void {
    this.items.push(item);
    console.log(`Item ${item.id} added.`);
  }

  // Method to find an item by ID
  // Returns T or undefined (if not found)
  getById(id: number): T | undefined {
    return this.items.find((item) => item.id === id);
  }

  /**
   * 5. Use Utility Type: Partial<T>
   * This allows us to pass an object with ONLY the fields we want to update,
   * rather than requiring the whole object.
   */
  update(id: number, updates: Partial<T>): boolean {
    const index = this.items.findIndex((item) => item.id === id);

    if (index === -1) return false;

    // Merge existing item with updates
    this.items[index] = { ...this.items[index], ...updates };
    return true;
  }

  // Returns a readonly array so outside code can't mutate the internal array directly
  getAll(): ReadonlyArray<T> {
    return this.items;
  }
}

// --- IMPLEMENTATION ---

// 6. Utility Type: Omit
// We use Omit to define the input for creating a task, 
// because 'id' and 'createdAt' will be handled automatically.
type CreateTaskInput = Omit<ITask, 'id' | 'createdAt'>;

// Helper to simulate an ID generator
let idCounter = 1;

function createTask(input: CreateTaskInput): ITask {
  return {
    id: idCounter++,
    ...input,
    createdAt: new Date(),
  };
}

// Initialize the generic manager strictly for ITask
const taskManager = new DataManager<ITask>();

// Create data
const task1 = createTask({ 
  title: "Fix Login Bug", 
  status: 'in-progress',
  description: "Auth token failing on refresh" 
});

const task2 = createTask({ 
  title: "Write Documentation", 
  status: 'pending' 
});

// Use the manager
taskManager.add(task1);
taskManager.add(task2);

// Update a specific field (Partial<T> in action)
taskManager.update(task1.id, { status: 'completed' });

// Fetch and log
const allTasks = taskManager.getAll();
console.log("Current Tasks:", allTasks);