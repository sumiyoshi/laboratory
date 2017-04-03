defmodule Sunta.Pagination.Navigation do
  @moduledoc false
  alias Sunta.Pagination.Navigation

  defstruct count: nil,
            current_page: nil,
            num_pages: nil,
            page_range: [],
            prev: nil,
            next: nil

  def get(opt) when is_list(opt) do

    count = do_get_count(opt)
    limit = do_get_limit(opt)

    current_page = do_get_current_page(opt)
    num_pages = do_get_num_pages(count, limit)

    prev = do_get_prev(current_page)
    next = do_get_next(current_page, num_pages)
    page_range = 1..num_pages |> Enum.to_list

    %Navigation{
      count: count, current_page: current_page,
      num_pages: num_pages, page_range: page_range,
      prev: prev, next: next
    }
  end

  defp do_get_count(opt) do
    Potion.get(opt, :count) |> Potion.to_integer
  end

  defp do_get_current_page(opt) do
    Potion.get(opt, :current_page) |> Potion.to_integer
  end

  defp do_get_limit(opt) do
    Potion.get(opt, :limit) |> Potion.to_integer
  end

  defp do_get_prev(current_page) do
    cond do
      current_page <= 1 -> nil
      true -> current_page - 1
    end
  end

  defp do_get_next(current_page, num_pages) do
    cond do
      current_page >= num_pages -> nil
      true -> current_page + 1
    end
  end

  defp do_get_num_pages(count, limit) do
    case limit do
      0 -> 0
      _ -> (count / limit) |> Float.ceil |> Potion.to_integer
    end
  end

end