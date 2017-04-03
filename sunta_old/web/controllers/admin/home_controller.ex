defmodule Sunta.Admin.HomeController do
  @moduledoc false
  use Sunta.Web, :controller
  alias Sunta.Auth.Authentication

  def index(conn, _) do
    user = Authentication.get_user(conn)
    render conn, "index.html", user: user
  end

end
