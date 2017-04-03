defmodule Sunta.AuthController do
  @moduledoc false
  use Sunta.Web, :controller

  alias Sunta.UserTasks
  alias Sunta.Auth.Authentication

  def index(conn, _) do
    render conn, "login.html"
  end

  def login(conn, %{"session" => %{"login_id" => login_id, "password" => password}}) do
    case UserTasks.login_by_name_and_pass(conn, login_id, password) do
      {:ok, conn, user} ->
        conn
        |> Authentication.login(user)
        |> put_flash(:info, "Welcome")
        |> redirect(to: home_path(conn, :index))
      {:error, _reason, conn} ->
        conn
        |> put_flash(:error, "ID / password is invalid")
        |> render("login.html")
    end
  end

  def logout(conn, _) do
    conn
    |> Authentication.logout()
    |> redirect(to: auth_path(conn, :index))
  end

end
