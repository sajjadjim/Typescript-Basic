function isPalindrome(str: string): boolean {
  const cleanStr = str.toLowerCase().replace(/[^a-z0-9]/g, "");
  return cleanStr === cleanStr.split("").reverse().join("");
}

console.log(isPalindrome("Racecar")); // true
console.log(isPalindrome("hello"));   // false
