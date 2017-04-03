defmodule Sunta.ControllerHelper do
  @moduledoc false
  use Phoenix.Controller

  alias Sunta.ErrorView

  @doc """
  404 page
  """
  def not_found(conn) do
    conn
    |> put_status(404)
    |> render(ErrorView, "404.html")
  end

end
