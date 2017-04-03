defmodule Mix.Tasks.Sunta.Reset.Admin do

  use Mix.Tasks.MixTask, :user

  @login_id "admin"

  def run(args) do
    start_task()
    args |> do_check() |> do_run() |> do_message()
  end

  defp do_check(args) do
    count =  User |> select([c], count(c.id)) |> Repo.get_by(login_id: @login_id)
     cond do
       count == 1 -> {:ok, args}
       true -> {:error, "It is not registered"}
     end
  end

  defp do_run({:ok, _args}) do
    changeset =  User
        |> Repo.get_by(login_id: @login_id)
        |> cast(%{}, [:name, :password, :set_password, :login_id, :administrator])
        |> User.set_pass()
        |> validate_required([:name, :password, :login_id, :administrator])
        |> User.put_pass_hash

    case Repo.update(changeset) do
      {:ok, user} -> {:ok, "Admin password changed to " <>user.set_password}
      {:error, _changeset} -> {:error, "update error"}
    end
  end
  defp do_run(any), do: any

end
