# 32. 動詞の原形

Mecab.parse(["data/neko.txt"])
|> Enum.filter_map(&(Map.get(&1, :pos, "") == "動詞"), &(Map.get(&1, :feature, "")))
|> IO.inspect