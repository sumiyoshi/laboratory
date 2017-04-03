defmodule Sunta.Admin.UserController do
  @moduledoc false
  use Sunta.Web, :controller

  alias Sunta.User
  alias Sunta.UserTasks
  alias Sunta.Auth.Authentication

  plug :admin_accessible_user, [level: 1] when action in [:index, :new, :create, :show, :edit, :update, :delete, :reset_password]

  def index(conn, %{"search" => search_params}) do
    %{users: users, navigation: navigation} = UserTasks.select(search_params)
    render(conn, "index.html", users: users, navigation: navigation, search_params: search_params)
  end

  def index(conn, _params) do
    %{users: users, navigation: navigation} = UserTasks.select(%{})
    render(conn, "index.html", users: users, navigation: navigation, search_params: %{})
  end

  def new(conn, _params) do
    changeset = User.registration_changeset(%User{})
    render(conn, "new.html", changeset: changeset)
  end

  def create(conn, %{"user" => user_params}) do
    case UserTasks.insert(user_params) do
      {:ok, user} ->
        conn
        |> put_flash(:info, "#{user.name}　user's created successfully. The password is 「#{user.set_password}」")
        |> redirect(to: user_path(conn, :index))
      {:error, changeset} ->
        render(conn, "new.html", changeset: changeset)
    end
  end

  def show(conn, %{"id" => id}) do
    user = Repo.get!(User, id)
    render(conn, "show.html", user: user)
  end

  def edit(conn, %{"id" => id}) do
    user = Repo.get!(User, id)
    changeset = User.update_changeset(user)
    render(conn, "edit.html", user: user, changeset: changeset)
  end

  def update(conn, %{"id" => id, "user" => user_params}) do
    case UserTasks.update(id, user_params) do
      {:ok, user} ->
        conn
        |> put_flash(:info, "User updated successfully.")
        |> redirect(to: user_path(conn, :show, user))
      {:error, changeset, user} ->
        render(conn, "edit.html", user: user, changeset: changeset)
    end
  end

  def delete(conn, %{"id" => id}) do
    user = Repo.get!(User, id)

    # Here we use delete! (with a bang) because we expect
    # it to always work (and if it does not, it will raise).
    Repo.delete!(user)

    conn
    |> put_flash(:info, "User deleted successfully.")
    |> redirect(to: user_path(conn, :index))
  end

  def reset_password(conn, %{"id" => id}) do
    case UserTasks.password_initialization(id) do
      {:ok, user} ->
        conn
        |> put_flash(:info, "#{user.name} user's password has been initialized. The password is 「#{user.set_password}」")
        |> redirect(to: user_path(conn, :index))
      {:error, _changeset} ->
        conn
        |> put_flash(:error, "Password initialization failed")
        |> redirect(to: user_path(conn, :index))
    end
  end

  def profile(conn, _params) do
    user = Authentication.get_user(conn)
    changeset = User.update_changeset(user)
    render(conn, "profile.html", user: user, changeset: changeset)
  end

  def profile_edit(conn, %{"user" => user_params}) do
    user = Authentication.get_user(conn)

    case UserTasks.update(user.id, user_params) do
      {:ok, _user} ->
        conn
        |> put_flash(:info, "User updated profile.")
        |> redirect(to: user_path(conn, :profile))
      {:error, changeset, user} ->
        render(conn, "profile.html", user: user, changeset: changeset)
    end
  end

end
