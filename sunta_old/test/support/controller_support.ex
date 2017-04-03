defmodule Sunta.ControllerSupport do
  defmacro __using__(args) do
    controller = Keyword.get(args, :controller)

    quote bind_quoted: [controller: controller] do
      use Plug.Test
      alias Sunta.Repo
      alias Sunta.User

      @controller controller

      def action(conn, action, params \\ %{}) do
        conn = conn
          |> put_private(:phoenix_controller, @controller)
          |> Phoenix.Controller.put_view(Phoenix.Controller.__view__(@controller))

        apply(@controller, action, [conn, params])
      end

      @session Plug.Session.init(
        store: :cookie,
        key: "_sunta_key",
        signing_salt: "pYbMsoH4"
      )

      defp with_session_and_flash(conn) do
        conn
        |> Map.put(:secret_key_base, String.duplicate("abcdefgh", 8))
        |> Plug.Session.call(@session)
        |> Plug.Conn.fetch_session()
        |> Phoenix.ConnTest.fetch_flash()
      end

      defp admin_login(conn) do
        {:ok, user} = User.registration_changeset(%User{}, get_admin_valid_attrs()) |> Repo.insert

        conn
        |> with_session_and_flash
        |> put_session(:user_id, user.id)
        |> configure_session(renew: true)
      end

      defp public_login(conn) do
        {:ok, user} = User.registration_changeset(%User{}, get_public_user_valid_attrs()) |> Repo.insert

        conn
        |> with_session_and_flash
        |> put_session(:user_id, user.id)
        |> configure_session(renew: true)
      end
    end
  end
end
