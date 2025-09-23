
def greet_user(name)
  puts "Hello, #{name}! Welcome to the Ruby world."
end

# Calling the method
greet_user("Jack")

# Simple calculation
def add_numbers(num1, num2)
  result = num1 + num2
  return result
end

# Printing the result of the calculation
puts "The sum of 5 and 3 is: #{add_numbers(5, 3)}"

# Looping example
(1..5).each do |i|
  puts "This is number #{i}"
end

# Hash example
user_data = {name: "Jack", age: 39, occupation: "IT Director"}
puts "User's name is #{user_data[:name]} and age is #{user_data[:age]}."

# Array example
fruits = ["Apple", "Banana", "Orange"]
fruits.each do |fruit|
  puts "Fruit: #{fruit}"
end
