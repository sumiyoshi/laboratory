# 20. JSONデータの読み込み

FileCommand.read_json("data/jawiki-country.json", ~r/\"title\":(.*)\"イギリス\"/)
|> FileCommand.write_json("data/20.json")