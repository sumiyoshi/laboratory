# 33. サ変名詞

Mecab.parse(["data/neko.txt"])
|> Enum.filter_map(&(Map.get(&1, :pos, "") == "名詞" && Map.get(&1, :pos1, "") == "サ変接続"), &(Map.get(&1, :feature, "")))
|> IO.inspect