# 18. 各行を3コラム目の数値の降順にソート

FileCommand.read("data/hightemp.txt")
|> Enum.sort(&((String.split(&1, "\t") |> Enum.at(2))) < (String.split(&2, "\t") |> Enum.at(2)))
|> IO.inspect()
