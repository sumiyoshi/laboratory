# 35. 名詞の連接

Mecab.parse(["data/neko.txt"])
|> Enum.reduce("", fn(map, acc) ->
  case Map.get(map, :pos, "") do
    "名詞" -> acc <> "\t" <> Map.get(map, :surface, "")
     _ -> acc <> "\n"
  end
end)
|> String.split("\n")
|> Enum.filter_map(&(&1 != "" && String.split(&1, "\t") |> Enum.count() > 2), &(String.split(&1, "\t") |> Enum.join("")))
|> IO.inspect