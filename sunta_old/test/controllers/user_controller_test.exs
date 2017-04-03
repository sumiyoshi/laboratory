defmodule Sunta.UserControllerTest do
  use Sunta.ConnCase
  use Sunta.ControllerSupport, controller: Sunta.Admin.UserController
  alias Sunta.User
  alias Sunta.UserTasks

  test "lists all entries on index", %{conn: conn} do
    conn = conn
           |> admin_login
           |> action( :index)
    assert html_response(conn, 200) =~ "Listing users"
  end

  test "renders form for new resources", %{conn: conn} do
    conn = conn
           |> admin_login
           |> action(:new)
    assert html_response(conn, 200) =~ "New user"
  end

  test "creates resource and redirects when data is valid", %{conn: conn} do
    conn = conn
           |> admin_login
           |> action(:create, %{"user" =>  get_user_valid_attrs()})
    assert redirected_to(conn) == user_path(conn, :index)
    assert Repo.get_by(User, get_user_serch_attrs())
  end

  test "confirmation of access rights of resources", %{conn: conn} do
    {:ok, user} = UserTasks.insert(get_public_user_valid_attrs())
    conn = post conn, auth_path(conn, :login), %{"session" => %{"login_id" => user.login_id, "password" => user.set_password}}
    conn = get conn, user_path(conn, :index)
    assert redirected_to(conn) == user_path(conn, :profile)
  end

  test "does not create resource and renders errors when data is invalid", %{conn: conn} do
    conn = conn
           |> admin_login
           |> action(:create, %{"user" =>  get_invalid_attrs()})
    assert html_response(conn, 200) =~ "New user"
  end

  test "shows chosen resource", %{conn: conn} do
    user = Repo.insert! %User{}
    conn = conn
           |> admin_login
           |> action(:show, %{"id" => user.id})

    assert html_response(conn, 200) =~ "Show user"
  end

  test "shows profile and edit", %{conn: conn} do
    {:ok, user} = UserTasks.insert(get_user_valid_attrs())
    conn = post conn, auth_path(conn, :login), %{"session" => %{"login_id" => user.login_id, "password" => user.set_password}}
    conn = get conn, user_path(conn, :profile)
    assert html_response(conn, 200) =~ "Profile"

    update_params = %{mail: "some_test@content", name: "some test"}

    conn = put conn, user_path(conn, :profile_edit), %{"user" => update_params}
    assert redirected_to(conn) == user_path(conn, :profile)
    assert Repo.get_by(User, update_params)
  end

  test "renders form for editing chosen resource", %{conn: conn} do
    user = Repo.insert! %User{}
    conn = conn
           |> admin_login
           |> action(:edit, %{"id" => user.id})
    assert html_response(conn, 200) =~ "Edit user"
  end

  test "updates chosen resource and redirects when data is valid", %{conn: conn} do
    user = Repo.insert! %User{}
    conn = conn
           |> admin_login
           |> action(:update, %{"id" => user.id, "user" => get_user_valid_attrs()})
    assert redirected_to(conn) == user_path(conn, :show, user)
    assert Repo.get_by(User, get_user_serch_attrs())
  end

  test "does not update chosen resource and renders errors when data is invalid", %{conn: conn} do
    user = Repo.insert! %User{}
    conn = conn
           |> admin_login
           |> action(:update, %{"id" => user.id, "user" => get_invalid_attrs()})
    assert html_response(conn, 200) =~ "Edit user"
  end

  test "deletes chosen resource", %{conn: conn} do
    user = Repo.insert! %User{}
    conn = conn
           |> admin_login
           |> action(:delete, %{"id" => user.id})
    assert redirected_to(conn) == user_path(conn, :index)
    refute Repo.get(User, user.id)
  end

  test "initialize the password of the selected user", %{conn: conn} do
    user = Repo.insert! %User{}
    conn = conn
           |> admin_login
           |> action(:reset_password, %{"id" => user.id})
    assert redirected_to(conn) == user_path(conn, :index)
  end
end
