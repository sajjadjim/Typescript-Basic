# advanced_calculator.rb

def display_menu
  puts "============================"
  puts "     Ruby Calculator 🧮"
  puts "============================"
  puts "Select an operation:"
  puts "1. Addition (+)"
  puts "2. Subtraction (-)"
  puts "3. Multiplication (*)"
  puts "4. Division (/)"
  puts "5. Modulus (%)"
  puts "6. Exponentiation (^)"
  puts "7. Exit"
  puts "============================"
end

def get_number(prompt)
  print prompt
  Float(gets.chomp) rescue nil
end

loop do
  display_menu
  print "Enter your choice (1–7): "
  choice = gets.chomp.to_i

  break if choice == 7

  num1 = get_number("Enter first number: ")
  num2 = get_number("Enter second number: ")

  if num1.nil? || num2.nil?
    puts "❌ Invalid number entered! Please try again."
    next
  end

  result =
    case choice
    when 1 then num1 + num2
    when 2 then num1 - num2
    when 3 then num1 * num2
    when 4
      if num2.zero?
        "Error: Division by zero!"
      else
        num1 / num2
      end
    when 5 then num1 % num2
    when 6 then num1**num2
    else
      "Invalid choice!"
    end

  puts "✅ Result: #{result}"
  puts
end

puts "👋 Thanks for using Ruby Calculator!"