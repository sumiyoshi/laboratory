defmodule Sunta.Auth.AuthorityBehaviour do
  @moduledoc false
  use Behaviour
  @callback not_access(conn :: Plug.Conn.__struct__) :: Plug.Conn.__struct__
end

defmodule Sunta.Auth.Authority do
  @moduledoc false

  @access_level [:admin]

  defmacro __using__(args) do
    controller = Keyword.fetch!(args, :controller)
    model = Keyword.fetch!(args, :model)
    repo = Keyword.fetch!(args, :repo)

    quote bind_quoted: [controller: controller, model: model, repo: repo] do

      alias Sunta.Auth.Authentication
      alias Sunta.Auth.Authority

      @controller controller
      @model model
      @repo repo

      def put_access_level(conn, opts) do
        user = Authentication.get_user(conn)

        if user do
          assign(conn, :access_level, user.administrator)
        else
          conn
        end
      end

      def admin_accessible_user(conn, _opts) do
        do_check_access(conn, :true)
      end

      defp do_check_access(conn, level) do
        if Authority.has_access(conn, level) do
          conn
        else
          @controller.not_access(conn)
        end
      end
    end
  end

  def has_access(conn, level) do
    get_level(conn) == level
  end

  def get_level(conn) do
    if Map.has_key?(conn, :assigns) && Map.has_key?(conn.assigns, :access_level) do
      Potion.to_atom(conn.assigns.access_level)
    else
      nil
    end
  end
end