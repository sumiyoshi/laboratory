defmodule Sunta.PartsView do
  @moduledoc false
  use Sunta.Web, :view

  def get_user_navigation(conn, search_params, page) do
    search_params = Potion.put(search_params, %{"page" => page})
    user_path(conn, :index, %{search: search_params})
  end

  def get_channel_navigation(conn, search_params, page) do
    search_params = Potion.put(search_params, %{"page" => page})
    channel_path(conn, :index, %{search: search_params})
  end
end
