# 14. 先頭からN行を出力
# @params int

argv = System.argv |> Enum.at(0)

if argv do
  n = argv  |> String.to_integer

  FileCommand.read("data/hightemp.txt")
  |> Enum.slice(0, n)
  |> Enum.join("\n")
  |> IO.inspect
end

