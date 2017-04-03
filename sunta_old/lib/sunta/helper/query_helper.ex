defmodule Sunta.QueryHelper do
  @moduledoc false
  import Ecto.Query

  @doc"""
  Generate a count query
  """
  def get_count_query(query) do
    query |> select([c], count(c.id))
  end

  @doc"""
  Generate a where clause
  """
  def add_where(query, list, fnc) do
    Enum.reduce(list, query, fn(tuple, acc) ->
      key = Potion.get(tuple, 0)
      value = Potion.get(tuple, 1)

      cond do
        !Potion.empty?(key) && !Potion.empty?(value) -> fnc.(acc, key, value)
        true -> acc
      end
    end)
  end

end
