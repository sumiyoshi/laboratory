# 09. Typoglycemia

do_string_shuffle = fn (str) ->
 str
 |> String.slice(1, String.length(str) - 2)
 |> String.split("")
 |> Enum.shuffle()
 |> Enum.join()
end

"I couldn't believe that I could actually understand what I was reading : the phenomenal power of the human mind ."
|> String.split(" ")
|> Enum.map(fn(str) ->
  case String.length(str) <= 4 do
    true -> str
    false -> String.at(str, 0) <> do_string_shuffle.(str) <> String.at(str, -1)
  end
end)
|> Enum.join(" ")
|> IO.inspect