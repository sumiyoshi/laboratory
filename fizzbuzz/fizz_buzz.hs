fizz_buzz :: Integer -> String
fizz_buzz n
    | mod n 15 == 0 = "FizzBuzz"
    | mod n 3 == 0 = "Fizz"
    | mod n 5 == 0 = "Buzz"
    | otherwise = show n

main = do
    print $ [ fizz_buzz x | x <- [1..100] ]