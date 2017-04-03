# 03. 円周率

"Now I need a drink, alcoholic of course, after the heavy lectures involving quantum mechanics."
|> String.replace(",", "") |> String.replace(".", "") |> String.split(" ")
|> Enum.map(&(String.length &1))
|> IO.inspect