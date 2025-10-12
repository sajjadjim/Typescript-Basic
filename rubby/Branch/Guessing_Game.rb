# guessing_game.rb
secret = rand(1..10)
tries = 0

loop do
  print "Guess the number (1–10): "
  guess = gets.to_i
  tries += 1

  if guess == secret
    puts "🎉 Correct! You guessed it in #{tries} tries."
    break
  else
    puts guess < secret ? "Too low!" : "Too high!"
  end
end