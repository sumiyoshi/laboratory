defmodule FizzBuzz do

  @spec get(Integer.t) :: String.t
  def get(num) when rem(num, 15) == 0, do: "FizzBuzz"

  def get(num) when rem(num, 3) == 0, do: "Fizz"

  def get(num) when rem(num, 5) == 0, do: "Buzz"

  def get(num), do: num

end

1..100 |> Enum.each(&(IO.puts FizzBuzz.get &1))