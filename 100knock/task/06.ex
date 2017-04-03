# 06. 集合

x = "paraparaparadise" |> Ngram.bi_ngram |> Enum.uniq
y = "paragraph" |> Ngram.bi_ngram |> Enum.uniq

IO.inspect(x ++ y |> Enum.uniq)
IO.inspect(x -- (x -- y) |> Enum.uniq)
IO.inspect(x -- y)

IO.inspect(x |> Enum.member?("se"))
IO.inspect(y |> Enum.member?("se"))