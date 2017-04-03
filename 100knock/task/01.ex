# 01. 「パタトクカシーー」

"パタトクカシーー" |> String.split("", trim: true) |> Stream.with_index
|> Enum.reduce("", fn({str, index}, acc) ->
  case Enum.member?([1,3,5,7], index + 1) do
    true -> acc <> str
    _ -> acc
  end
end)
|> IO.inspect