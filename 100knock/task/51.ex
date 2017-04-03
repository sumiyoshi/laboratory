# 51. 単語の切り出し

FileCommand.read_string("data/50.txt")
|> String.split("\n")
|> Enum.filter(&(String.length(&1) > 0))
|> Enum.map(&(String.split(&1, " ") ++ [""]))
|> Enum.concat
|> Enum.join("\n")
|> FileCommand.write("data/51.txt")