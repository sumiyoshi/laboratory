defmodule Sunta.Auth.AuthenticationBehaviour do
  @moduledoc false
  use Behaviour
  @callback uncertified(conn :: Plug.Conn.__struct__) :: Plug.Conn.__struct__
end

defmodule Sunta.Auth.Authentication do
  @moduledoc false
  import Plug.Conn

  defmacro __using__(args) do
    controller = Keyword.fetch!(args, :controller)
    model = Keyword.fetch!(args, :model)
    repo = Keyword.fetch!(args, :repo)

    quote bind_quoted: [controller: controller, model: model, repo: repo] do

      @controller controller
      @model model
      @repo repo

      def put_current_user(conn, opts) do
        id = get_session(conn, :id)
        user = id && @repo.get(@model, id)
        assign(conn, :current_user, user)
      end

      def authenticate_user(conn, _opts) do
        if Sunta.Auth.Authentication.get_user(conn) do
          conn
        else
          @controller.uncertified(conn)
        end
      end
    end
  end

  def get_user(conn) do
    if Map.has_key?(conn, :assigns) && Map.has_key?(conn.assigns, :current_user) do
      conn.assigns.current_user
    else
      nil
    end
  end

  def login(conn, user) do
    conn
    |> assign(:current_user, user)
    |> put_session(:id, user.id)
    |> configure_session(renew: true)
  end

  def logout(conn) do
    configure_session(conn, drop: true)
  end
end