# 04. 元素記号

"Hi He Lied Because Boron Could Not Oxidize Fluorine. New Nations Might Also Sign Peace Security Clause. Arthur King Can."
|> String.split(" ") |> Stream.with_index
|> Enum.reduce(%{}, fn({str, index}, map) ->
  case Enum.member?([1, 5, 6, 7, 8, 9, 15, 16, 19], index) do
    false -> Map.put(map, String.slice(str, 0, 2), index)
    true -> Map.put(map, String.slice(str, 0, 1), index)
  end
end)
|> IO.inspect