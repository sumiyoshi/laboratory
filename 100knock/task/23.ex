# 記事中に含まれるセクション名とそのレベル（例えば"== セクション名 =="なら1）を表示せよ

pattern = ~r/(={2,}+)(.*)/

FileCommand.read_json("data/20.json")
|> Enum.map(fn(map) ->
 Regex.scan(pattern, map["text"])
 |> Enum.map(fn(scan) ->
   %{section: Enum.at(scan, 2) |> String.replace("=", ""), level: (Enum.at(scan, 1) |> String.length) - 1}
 end)
end)
|> Enum.concat
|> IO.inspect