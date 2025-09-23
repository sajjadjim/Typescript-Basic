# person.rb
class Person
  attr_accessor :name, :age
  
  def initialize(name, age)
    @name = name
    @age = age
  end
  
  def greet
    puts "Hello, my name is #{@name} and I am #{@age} years old."
  end
end

# Create an instance of Person
person1 = Person.new("Jack", 39)
person1.greet

person2 = Person.new("Jane", 34)
person2.greet
