defmodule Mix.Tasks.Sunta.Gen.Admin do
  use Mix.Tasks.MixTask, :user

  @login_id "admin"
  @user %{name: @login_id,  login_id: @login_id, administrator: true}

  def run(args) do
    start_task()
    args |> do_check() |> do_run() |> do_message()
  end

  defp do_check(args) do
    count =  User |> select([c], count(c.id)) |> Repo.get_by(login_id: @login_id)
     cond do
       count > 0 -> {:error, "It's registered already."}
       true -> {:ok, args}
     end
  end

  defp do_run(_args) do
    changeset = %User{}
        |> cast(@user, [:name, :password, :set_password, :login_id, :administrator])
        |> User.set_pass()
        |> validate_required([:name, :password, :login_id, :administrator])
        |> User.put_pass_hash

    case Repo.insert(changeset) do
      {:ok, user} -> {:ok, "Created a admin. Password is " <> user.set_password}
      {:error, _changeset} -> {:error, "insert error"}
    end
  end

end
