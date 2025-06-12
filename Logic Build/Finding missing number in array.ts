function findMissingNumber(arr: number[], n: number): number {
  const total = (n * (n + 1)) / 2;
  const sum = arr.reduce((acc, val) => acc + val, 0);
  return total - sum;
}

console.log(findMissingNumber([1, 2, 4, 5, 6], 6)); // 3
