# calculator.rb
def add(a, b)
  a + b
end

def subtract(a, b)
  a - b
end

def multiply(a, b)
  a * b
end

def divide(a, b)
  return "Cannot divide by zero" if b == 0
  a / b.to_f
end

# Test the calculator
puts "Addition: 5 + 3 = #{add(5, 3)}"
puts "Subtraction: 5 - 3 = #{subtract(5, 3)}"
puts "Multiplication: 5 * 3 = #{multiply(5, 3)}"
puts "Division: 5 / 3 = #{divide(5, 3)}"
puts "Division by zero: #{divide(5, 0)}"
