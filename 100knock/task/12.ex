# 12. 1列目をcol1.txtに，2列目をcol2.txtに保存

file = FileCommand.read("data/hightemp.txt")

file
|> Enum.map(&(String.split(&1, "\t") |> Enum.at(0)))
|> Enum.join("\n")
|> FileCommand.write("data/col1.txt")

file
|> Enum.map(&(String.split(&1, "\t") |> Enum.at(1)))
|> Enum.join("\n")
|> FileCommand.write("data/col2.txt")