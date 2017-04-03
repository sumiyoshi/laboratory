# 31. 動詞

Mecab.parse(["data/neko.txt"])
|> Enum.filter_map(&(Map.get(&1, :pos, "") == "動詞"), &(Map.get(&1, :surface, "")))
|> IO.inspect