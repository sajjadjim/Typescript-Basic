function fibonacciRecursive(n: number): number {
  if (n <= 1) {
    return n;
  }
  return fibonacciRecursive(n - 1) + fibonacciRecursive(n - 2);
}
console.log(fibonacciRecursive(10)); // Output: 55

function fibonacciIterative(n: number): number {
  if (n <= 1) {
    return n;
  }
  let prev = 0, curr = 1;
  for (let i = 2; i <= n; i++) {
    const next = prev + curr;
    prev = curr;
    curr = next;
  }
  return curr;
}
console.log(fibonacciIterative(10)); // Output: 55 //