defmodule Sunta.ValidateHelper do
  @moduledoc false
  import Ecto.Changeset
  alias Sunta.Repo

  @regex_password ~r/([a-zA-Z0-9\!\?]).*/
  @regex_alphanumeric ~r/([a-zA-Z0-9]).*/
  @regex_mail ~r/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/

  @doc """
  Checking the password
  """
  def validate_password(changeset, field) do
    changeset
    |> validate_length(field, [min: 4, max: 15])
    |> validate_format(field, @regex_password)
  end

  @doc """
  Checking the half size alphanumeric
  """
  def validate_alphanumeric(changeset, field) do
    changeset
    |> validate_format(field, @regex_alphanumeric)
  end

  @doc """
  Checking the login id
  """
  def validate_login_id(changeset, field) do
    changeset
    |> validate_length(field, [max: 50])
    |> validate_alphanumeric(field)
    |> validate_exclusion(field, ~w(admin))
    |> validate_unique(field, Sunta.User)
  end

  @doc """
  Checking the mail
  """
  def validate_mail(changeset, field) do
    changeset
    |> validate_length(field, [max: 100])
    |> validate_format(field, @regex_mail)
  end

  @doc """
  Unique check
  """
  def validate_unique(changeset, field, model) do
    changeset |> validate_change(field, &do_unique(&1, &2, model))
  end

  defp do_unique(field, value, model) do
    if Repo.get_by(model, %{field => value}) do
      ["#{field}": "It's registered already."]
    else
      []
    end
  end

end
