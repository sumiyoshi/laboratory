defmodule Sunta.Channel do
  use Sunta.Web, :model

  schema "channels" do
    field :channel_key, :string
    field :title, :string
    field :content, :string
    field :release_date, Ecto.DateTime
    field :draft, :boolean, default: false

    timestamps()
  end

  @doc """
  Builds a changeset based on the `struct` and `params`.
  """
  def changeset(struct, params \\ %{}) do

    struct
    |> cast(params, [:channel_key, :title, :content, :release_date, :draft])
    |> validate_length(:channel_key, [max: 50])
    |> validate_alphanumeric(:channel_key)
    |> validate_unique(:channel_key, Sunta.Channel)
    |> validate_length(:title, [max: 50])
    |> validate_length(:content, [max: 1000])
    |> validate_exclusion(:draft, ~w(true false))
    |> validate_required([:channel_key, :title, :content, :release_date, :draft])
  end
end
