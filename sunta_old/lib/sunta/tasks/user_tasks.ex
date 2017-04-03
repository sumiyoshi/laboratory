defmodule Sunta.UserTasks do
  use Sunta.Web, :tasks

  import Comeonin.Bcrypt, only: [checkpw: 2, dummy_checkpw: 0]

  alias Sunta.User
  alias Sunta.QueryHelper
  alias Sunta.Pagination.Navigation

  @limit 10

  @doc """
  User insert
  """
  def insert(params) do
    changeset = User.registration_changeset(%User{}, params)
    Repo.insert(changeset)
  end

  @doc """
  User update
  """
  def update(id, params) do
    user = Repo.get!(User, id)
    changeset = User.update_changeset(user, params)

    case Repo.update(changeset) do
      {:ok, user} -> {:ok, user}
      {:error, changeset} -> {:error, changeset, user}
    end
  end

  @doc """
  User password initialization
  """
  def password_initialization(id) do
    user = Repo.get!(User, id)
    changeset = User.registration_changeset(user)
    Repo.update(changeset)
  end

  @doc """
  User search
  """
  def select(params) do
    query = User |> add_where(Potion.trim(params))

    page = Potion.get(params, "page", "1") |> Potion.to_integer
    limit = @limit
    offset = @limit * (page - 1)

    count = Repo.one(QueryHelper.get_count_query(query))
    users =  query |> limit(^limit) |> offset(^offset) |> Repo.all()
    navigation = Navigation.get(count: count, current_page: page, limit: limit)

    %{users: users, navigation: navigation}
  end

  @doc """
  Authentication check
  """
  def login_by_name_and_pass(conn, login_id, password) do

    user = Repo.get_by(User, login_id: login_id)
    cond do
      user && checkpw(password, user.password) ->
        {:ok, conn, user}
      true ->
        dummy_checkpw()
        {:error, :not_found, conn}
    end
  end

  defp add_where(query, items) do
    QueryHelper.add_where(query, items, fn(query, key, value) ->
      case key do
        "name_like" -> where(query, [u], like(u.name, ^("#{value}%")))
        "login_id_like" -> where(query, [u], like(u.login_id, ^("#{value}%")))
        "mail_like" -> where(query, [u], like(u.mail, ^("#{value}%")))
        _ -> query
      end
    end)
  end

end
