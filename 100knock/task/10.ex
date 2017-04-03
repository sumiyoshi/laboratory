# 10. 行数のカウント
# @params data/hightemp.txt

name = System.argv |> Enum.at(0)

if name do
  FileCommand.read(name)
  |> Enum.count
  |> IO.inspect
end
