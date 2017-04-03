# 11. タブをスペースに置換

FileCommand.read("data/hightemp.txt")
|> Enum.map(&(String.replace(&1, "\t", " ")))
|> IO.inspect