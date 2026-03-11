/**
 * How to write a function in TypeScript
 * This example demonstrates a big function that performs multiple tasks:
 * - Accepts an array of numbers
 * - Filters out negative numbers
 * - Calculates the sum and average
 * - Finds the maximum and minimum values
 * - Returns an object with all results
 */

function analyzeNumbers(numbers: number[]): {
    filtered: number[];
    sum: number;
    average: number;
    max: number;
    min: number;
} {
    // Filter out negative numbers
    const filtered = numbers.filter(n => n >= 0);

    // Calculate sum
    const sum = filtered.reduce((acc, curr) => acc + curr, 0);

    // Calculate average
    const average = filtered.length > 0 ? sum / filtered.length : 0;

    // Find max and min
    const max = filtered.length > 0 ? Math.max(...filtered) : 0;
    const min = filtered.length > 0 ? Math.min(...filtered) : 0;

    // Return results as an object
    return {
        filtered,
        sum,
        average,
        max,
        min
    };
}

// Example usage:
const result = analyzeNumbers([10, -5, 20, 0, 7, -2, 15]);
console.log(result);
/*
{
    filtered: [10, 20, 0, 7, 15],
    sum: 52,
    average: 10.4,
    max: 20,
    min: 0
}
*/
// Another example usage:
const moreNumbers = [5, -3, 12, 8, -1, 0, 4];
const analysis = analyzeNumbers(moreNumbers);
console.log(analysis);
/*
{
    filtered: [5, 12, 8, 0, 4],
    sum: 29,
    average: 5.8,
    max: 12,
    min: 0
}
*/

// Edge case: all negative numbers
const negativeNumbers = [-10, -20, -30];
const negativeAnalysis = analyzeNumbers(negativeNumbers);
console.log(negativeAnalysis);
/*
{
    filtered: [],
    sum: 0,
    average: 0,
    max: 0,
    min: 0
}
*/

// Edge case: empty array
const emptyAnalysis = analyzeNumbers([]);
console.log(emptyAnalysis);
/*
{
    filtered: [],
    sum: 0,
    average: 0,
    max: 0,
    min: 0
}
*/