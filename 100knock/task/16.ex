# 16. ファイルをN分割する
# @params int

argv = System.argv |> Enum.at(0)

if argv do
  n = argv |> String.to_integer

  file = FileCommand.read("data/hightemp.txt")
  slice_count = (Enum.count(file) / n) |> Float.ceil |> round

  1..n
  |> Enum.map(fn(x) ->
    Enum.slice(file, (x - 1) * slice_count, slice_count)
    |> Enum.join("\n")
    |> FileCommand.write("data/#{x}.txt")
  end)
end

