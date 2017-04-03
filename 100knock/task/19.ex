# 19. 各行の1コラム目の文字列の出現頻度を求め，出現頻度の高い順に並べる

file = FileCommand.read("data/hightemp.txt")

key_list = file |> Enum.map(&(String.split(&1, "\t") |> Enum.at(0)))

key_list
|> Enum.uniq
|> Enum.sort(fn(x, y) ->
 (Enum.filter(key_list, &(&1 == x)) |> Enum.count) > (Enum.filter(key_list, &(&1 == y)) |> Enum.count)
end)
|> IO.inspect()
