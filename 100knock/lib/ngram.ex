defmodule Ngram do

  def uni_ngram(input) do
    do_ngram(input, 1)
  end

  def bi_ngram(input) do
    do_ngram(input, 2)
  end

  def tri_ngram(input) do
    do_ngram(input, 3)
  end

  defp do_ngram(input, n) when is_binary(input) do
    0..String.length(input) - n
    |> Enum.map(&(String.slice input, &1, n))
  end

  defp do_ngram(input, n) when is_list(input) do
    0..Enum.count(input) - n
    |> Enum.map(&(Enum.slice input, &1, n))
  end

end