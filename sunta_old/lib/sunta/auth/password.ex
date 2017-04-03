defmodule Sunta.Auth.Password do
  @moduledoc false

  @words 'abcdefghijklmnopqrstuvwxyz'
  @sub_words '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ!?'

  def gen(length \\ 10) do
    cond do
      length >= 4 && length <= 6 -> do_password_generation(length, 1)
      length >= 7 && length <= 10 -> do_password_generation(length, 2)
      length >= 11 && length <= 15 -> do_password_generation(length, 3)
      true -> raise RuntimeError, message: "4 to 15 digits"
    end
  end

  def do_password_generation(length, sub_word_count) do
    sub_word = Enum.shuffle(@sub_words) |> Enum.slice(0, sub_word_count)
    word = Enum.shuffle(@words) |> Enum.slice(0, length - sub_word_count)

    Enum.concat(word, sub_word) |> Enum.shuffle() |> List.to_string()
  end

end