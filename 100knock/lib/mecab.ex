defmodule Mecab do

  defstruct [:surface, :feature, :pos, :pos1, :base]

  def parse(input) do
    System.cmd("mecab", input)
    |> Tuple.to_list()
    |> Enum.at(0)
    |> String.split("\n")
    |> Enum.filter_map(&(&1 != "EOS" && &1 != ""), &do_parse_line(&1))
  end

  defp do_parse_line(line) do
    [s, f] = String.split(line, "\t")

    case String.split(f, ",") do
      [p, p1, _, _, _, _, b, _, _] ->
        %Mecab{surface: s, feature: f, pos: p, pos1: p1, base: b}
      [p, p1, _, _, _, _, b] ->
        %Mecab{surface: s, feature: f, pos: p, pos1: p1, base: b}
      _ ->
        {:error, "cannot parse line"}
      end
    end

end