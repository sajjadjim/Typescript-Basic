function fibonacciMemoized(n: number, memo: number[] = []): number {
  if (n <= 1) {
    return n;
  }
  if (memo[n] !== undefined) {
    return memo[n];
  }
  memo[n] = fibonacciMemoized(n - 1, memo) + fibonacciMemoized(n - 2, memo);
  return memo[n];
}

// Example usage:
console.log(fibonacciMemoized(10)); // Output: 55
