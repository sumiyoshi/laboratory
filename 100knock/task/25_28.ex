# 25. テンプレートの抽出

tmp = FileCommand.read_json("data/20.json")
|> Enum.map(fn(map) ->
 Regex.scan(~r/\n\{\{基礎情報 国((\n|.)*\n\}\})/, map["text"]) |> Enum.map(&(Enum.at(&1, 1)))
end)
|> Enum.concat
|> Enum.at(0)

result = Regex.scan(~r/\n\|(.*)\s=\s(.*)/, tmp) |> Enum.map(&(%{label: Enum.at(&1, 1), data: Enum.at(&1, 2)}))

#26. 強調マークアップの除去
result = Enum.map(result, &(%{label: &1.label, data: &1.data |> String.replace(~r/\'{1,4}/, "")}))

#27. 内部リンクの除去
result = Enum.map(result, &(%{label: &1.label, data: &1.data |> String.replace(~r/\[{1,2}|\]{1,2}/, "")}))

#28. MediaWikiマークアップの除去
result = Enum.map(result, &(%{label: &1.label, data: &1.data |> String.replace(~r/(<(.*)>(.*)<(.*)>)|<(.*)\/>/, "")}))

IO.inspect(result)