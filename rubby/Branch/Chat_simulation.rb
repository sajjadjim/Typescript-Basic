# chatbot.rb
puts "Hi! I’m RubyBot 🤖. Type 'bye' to exit."
loop do
  print "You: "
  msg = gets.chomp.downcase
  break if msg == "bye"

  responses = [
    "Interesting!",
    "Tell me more!",
    "I see...",
    "Wow, really?",
    "That's cool!"
  ]
  puts "RubyBot: #{responses.sample}"
end
puts "RubyBot: Goodbye!"