# 02. 「パトカー」＋「タクシー」＝「パタトクカシーー」


"パトカー" |> String.split("", trim: true) |> Stream.with_index
|> Enum.reduce("", fn({str, index}, acc) -> acc <> str <> String.at("タクシー", index) end)
|> IO.inspect