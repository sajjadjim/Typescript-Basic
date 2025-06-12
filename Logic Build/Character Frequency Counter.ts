function charFrequency(str: string): Record<string, number> {
  const freq: Record<string, number> = {};
  for (const char of str) {
    freq[char] = (freq[char] || 0) + 1;
  }
  return freq;
}

console.log(charFrequency("hello")); // { h: 1, e: 1, l: 2, o: 1 }
