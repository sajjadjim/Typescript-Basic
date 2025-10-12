# oop_calc.rb

class Calculator
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
    return "Error: Division by zero!" if b == 0
    a / b
  end
end

calc = Calculator.new

puts "Enter first number:"
a = gets.to_f
puts "Enter second number:"
b = gets.to_f
puts "Enter operation (+, -, *, /):"
op = gets.chomp

result = case op
         when "+" then calc.add(a, b)
         when "-" then calc.subtract(a, b)
         when "*" then calc.multiply(a, b)
         when "/" then calc.divide(a, b)
         else "Invalid operation!"
         end

puts "Answer: #{result}"