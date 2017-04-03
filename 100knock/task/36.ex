# 36. 単語の出現頻度



Mecab.parse(["data/neko.txt"])
|> Enum.map(&(Map.get(&1, :surface, "")))
|> Enum.group_by(&(&1))
|> Enum.reduce([], fn(map, acc) ->
  acc ++ [{elem(map, 0), Enum.count(elem(map, 1))}]
end)
|> IO.inspect