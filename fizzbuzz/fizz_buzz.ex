# Elixir 1.4.2

defmodule FizzBuzz do

  def run(), do: run(1)

  def run(num) when num > 100, do: :ok

  def run(num) do
    do_run(num) |> IO.inspect
    run(num + 1)
  end

  defp do_run(num) when rem(num, 15) == 0, do: "FizzBuzz"

  defp do_run(num) when rem(num, 3) == 0, do: "Fizz"

  defp do_run(num) when rem(num, 5) == 0, do: "Buzz"

  defp do_run(num), do: num

end

FizzBuzz.run()
