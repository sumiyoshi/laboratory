defmodule Sunta.User do
  use Sunta.Web, :model

  alias Sunta.Auth.Password

  schema "users" do
    field :name, :string
    field :password, :string
    field :set_password, :string, virtual: true
    field :mail, :string
    field :login_id, :string
    field :administrator, :boolean

    timestamps()
  end

  @doc """
  Builds a changeset based on the `struct` and `params`.
  """
  def registration_changeset(struct, params \\ %{}) do
    struct
    |> cast(params, [:name, :password, :set_password, :mail, :login_id, :administrator])
    |> set_pass()
    |> validate_length(:name, [max: 50])
    |> validate_login_id(:login_id)
    |> validate_password(:password)
    |> validate_mail(:mail)
    |> validate_exclusion(:administrator, ~w(true false))
    |> validate_required([:name, :password, :mail, :login_id, :administrator])
    |> put_pass_hash
  end

  @doc """
  Builds a changeset based on the `struct` and `params`.
  """
  def update_changeset(struct, params \\ %{}) do
    struct
    |> cast(params, [:name, :mail, :login_id, :administrator])
    |> validate_length(:name, [max: 50])
    |> validate_login_id(:login_id)
    |> validate_mail(:mail)
    |> validate_required([:name, :mail, :login_id])
  end

  def set_pass(changeset) do
    case changeset do
      %Ecto.Changeset{valid?: true, data: %{password: _pass}} ->
        password = Password.gen(6)
        changeset |> put_change(:password, password) |> put_change(:set_password, password)
      _ ->
        changeset
    end
  end

  @doc """
  Password encryption
  """
  def put_pass_hash(changeset) do
    case changeset do
      %Ecto.Changeset{valid?: true, changes: %{password: pass}} ->
        put_change(changeset, :password, Comeonin.Bcrypt.hashpwsalt(pass))
      _ ->
        changeset
    end
  end

end
