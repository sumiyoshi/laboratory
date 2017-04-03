# 15. 末尾のN行を出力
# @params int

argv = System.argv |> Enum.at(0)

if argv do
  n = argv  |> String.to_integer

  FileCommand.read("data/hightemp.txt")
  |> Enum.slice(-n, n)
  |> Enum.join("\n")
  |> IO.inspect
end

