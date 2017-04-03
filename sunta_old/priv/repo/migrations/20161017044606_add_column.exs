defmodule Sunta.Repo.Migrations.AddColumn do
  use Ecto.Migration

  def change do
    alter table(:users) do
      add :login_id, :string
    end
  end
end
