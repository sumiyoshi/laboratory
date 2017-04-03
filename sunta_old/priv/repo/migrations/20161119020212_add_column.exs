defmodule Sunta.Repo.Migrations.AddColumn do
  use Ecto.Migration

  def change do
    alter table(:users) do
      add :administrator, :boolean, default: false, null: false
    end
  end
end
