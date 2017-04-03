# 50. 文区切り

FileCommand.read_string("data/nlp.txt")
|> String.replace(~r/(\.|\;|\:|\?|\!){1,1}(\s)([A-Z]{1,1})/, "\\1\n\\3")
|> FileCommand.write("data/50.txt")