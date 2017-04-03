# 13. col1.txtとcol2.txtをマージ


file2 = FileCommand.read("data/col2.txt")

FileCommand.read("data/col1.txt")
|> Enum.with_index
|> Enum.map(fn({str, index}) ->
  line = Enum.at(file2, index)
  case line do
    nil -> str
    _ -> str <> "\t" <> line;
  end
end)
|> Enum.join("\n")
|> FileCommand.write("data/marge.txt")