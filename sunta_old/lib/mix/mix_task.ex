defmodule Mix.Tasks.MixTask do
  @moduledoc false

  import Supervisor.Spec

  def user do
    quote do
      use Mix.Task
      use Ecto.Schema

      import Ecto.Changeset
      import Ecto.Query
      import Mix.Tasks.MixTask

      alias Sunta.Repo
      alias Sunta.User
    end
  end

  @doc """
  When used, dispatch to the appropriate controller/view/etc.
  """
  defmacro __using__(which) when is_atom(which) do
    apply(__MODULE__, which, [])
  end

  def start_task() do
    children = [
      supervisor(Sunta.Repo, []),
    ]
    opts = [strategy: :one_for_one, name: Sunta.Supervisor]
    Supervisor.start_link(children, opts)
  end

  def do_message({:ok, message}) do
    IO.inspect(message)
  end

  def do_message({:error, message}) do
    IO.inspect(message)
  end
end
