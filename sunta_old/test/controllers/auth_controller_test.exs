defmodule Sunta.AuthControllerTest do
  use Sunta.ConnCase

  alias Sunta.UserTasks

  @login_param_false %{"session" => %{"login_id" => "", "password" => ""}}

  test "show login", %{conn: conn} do
    conn = get conn, auth_path(conn, :index)
    assert html_response(conn, 200) =~ "Login"
  end

  test "check login when OK", %{conn: conn} do
    {:ok, user} = UserTasks.insert(get_user_valid_attrs())
    conn = post conn, auth_path(conn, :login), %{"session" => %{"login_id" => get_login_id(), "password" => user.set_password}}
    assert redirected_to(conn) == home_path(conn, :index)
  end

  test "check login when NG", %{conn: conn} do
     conn = post conn, auth_path(conn, :login), @login_param_false
     assert html_response(conn, 200) =~ "ID / password is invalid"
  end

  test "check logout when OK", %{conn: conn} do
    {:ok, user} = UserTasks.insert(get_user_valid_attrs())
    conn = post conn, auth_path(conn, :login), %{"session" => %{"login_id" => get_login_id(), "password" => user.set_password}}
    conn = get conn, auth_path(conn, :logout)
    assert redirected_to(conn) == auth_path(conn, :index)
  end

end
