# 24. ファイル参照の抽出

pattern = ~r/\[\[(ファイル:|File:)(.*)(\|.*)(\|.*)(\|.*)\]\]/

FileCommand.read_json("data/20.json")
|> Enum.map(fn(map) ->
 Regex.scan(pattern, map["text"])
 |> Enum.map(&(Enum.at(&1, 2)))
end)
|> Enum.concat
|> IO.inspect