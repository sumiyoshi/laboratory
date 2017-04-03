# 21. カテゴリ名を含む行を抽出

FileCommand.read_json("data/20.json")
|> Enum.map(fn(map) ->
 Regex.scan(~r/\[\[Category:(.*)\]\]/, map["text"]) |> Enum.map(&(Enum.at(&1, 0)))
end)
|> Enum.concat
|> Enum.join("\n")
|> IO.inspect
