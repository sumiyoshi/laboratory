# 07. テンプレート

do_cast_string = fn
 (str) when is_integer(str) -> str |> Integer.to_string()
 (str) when is_float(str) -> str |> Float.to_string()
 (str) -> str
end

template = fn(x, y, z) ->
  do_cast_string.(x) <> "時の" <> do_cast_string.(y) <> "は" <> do_cast_string.(z)
end

template.(12, "気温", 22.4)
|> IO.inspect