defmodule Sunta.LayoutView do
  @moduledoc false
  use Sunta.Web, :view
  alias Sunta.Auth.Authentication

  def login_user_name(conn) do
    user = Authentication.get_user(conn)
    user.name
  end

  def get_title(conn) do
    Potion.get(conn.assigns, :title)
  end

  def is_admin(conn) do
    user = Authentication.get_user(conn)
    user.administrator == true
  end
end
