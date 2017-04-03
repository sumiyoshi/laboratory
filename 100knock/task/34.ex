# 34. 「AのB」

maps = Mecab.parse(["data/neko.txt"])
|> Enum.filter_map(fn(map) ->
  (Map.get(map, :pos1, "") == "連体化" && Map.get(map, :surface, "") == "の") || Map.get(map, :pos, "") == "名詞"
end, &(Map.get(&1, :base, "")))

maps
|> Enum.with_index
|> Enum.reduce([], fn({str, index}, acc) ->
  case str == "の" do
    true -> acc ++ [Enum.at(maps, index - 1) <> str <> Enum.at(maps, index + 1)]
    _ -> acc
  end
end)
|> IO.inspect