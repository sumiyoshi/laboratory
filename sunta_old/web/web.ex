defmodule Sunta.Web do
  @moduledoc false

  def model do
    quote do
      use Ecto.Schema

      import Ecto
      import Ecto.Changeset
      import Ecto.Query
      import Sunta.ValidateHelper
    end
  end

  def tasks do
    quote do
      alias Sunta.Repo
      import Ecto
      import Ecto.Query
    end
  end

  def controller do
    quote do
      use Phoenix.Controller

      alias Sunta.Repo
      import Ecto
      import Ecto.Query

      import Sunta.Router.Helpers
      import Sunta.Gettext
      use Sunta.Auth.Authority, [model: Sunta.User, repo: Sunta.Repo, controller: Sunta.SystemController]
    end
  end

  def view do
    quote do
      use Phoenix.View, root: "web/templates"

      # Import convenience functions from controllers
      import Phoenix.Controller, only: [get_csrf_token: 0, get_flash: 2, view_module: 1]

      # Use all HTML functionality (forms, tags, etc)
      use Phoenix.HTML

      import Sunta.Router.Helpers
      import Sunta.ErrorHelpers
      import Sunta.Gettext
    end
  end

  def router do
    quote do
      use Phoenix.Router
      use Sunta.Auth.Authentication, [model: Sunta.User, repo: Sunta.Repo, controller: Sunta.SystemController]
      use Sunta.Auth.Authority, [model: Sunta.User, repo: Sunta.Repo, controller: Sunta.SystemController]
    end
  end

  def channel do
    quote do
      use Phoenix.Channel

      alias Sunta.Repo
      import Ecto
      import Ecto.Query
      import Sunta.Gettext
    end
  end

  @doc """
  When used, dispatch to the appropriate controller/view/etc.
  """
  defmacro __using__(which) when is_atom(which) do
    apply(__MODULE__, which, [])
  end
end
