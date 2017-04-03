defmodule Sunta.Repo.Migrations.CreateChannel do
  use Ecto.Migration

  def change do
    create table(:channels) do
      add :channel_key, :string
      add :title, :string
      add :content, :text
      add :release_date, :datetime
      add :draft, :boolean, default: false, null: false

      timestamps()
    end

  end
end
