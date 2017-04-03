defmodule Sunta.UserTest do
  use Sunta.ModelCase

  alias Sunta.User

  test "changeset with valid attributes" do
    changeset = User.registration_changeset(%User{}, get_user_valid_attrs())
    assert changeset.valid?
  end

  test "changeset with invalid attributes" do
    changeset = User.registration_changeset(%User{}, get_invalid_attrs())
    refute changeset.valid?
  end
end
