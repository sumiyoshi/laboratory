# 17. １列目の文字列の異なり

FileCommand.read("data/hightemp.txt")
|> Enum.map(&(String.split(&1, "\t") |> Enum.at(0)))
|> Enum.uniq
|> IO.inspect()
