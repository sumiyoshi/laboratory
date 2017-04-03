defmodule Sunta.SystemController do
  @moduledoc false

  @behaviour Sunta.Auth.AuthenticationBehaviour
  @behaviour Sunta.Auth.AuthorityBehaviour

  use Sunta.Web, :controller

  def uncertified(conn) do
    conn
    |> put_flash(:error, "Please login")
    |> redirect(to: auth_path(conn, :index))
    |> halt()
  end
  
  def not_access(conn) do
    conn
    |> redirect(to: user_path(conn, :profile))
    |> halt()
  end

end
