defmodule Sunta.ChannelControllerTest do
  use Sunta.ConnCase
  use Sunta.ControllerSupport, controller: Sunta.Admin.ChannelController

  alias Sunta.Channel

  test "lists all entries on index", %{conn: conn} do
    conn = conn
           |> admin_login
           |> action( :index)
    assert html_response(conn, 200) =~ "Listing channels"
  end

  test "renders form for new resources", %{conn: conn} do
    conn = conn
           |> admin_login
           |> action(:new)
    assert html_response(conn, 200) =~ "New channel"
  end

  test "creates resource and redirects when data is valid", %{conn: conn} do
    conn = conn
           |> admin_login
           |> action(:create, %{"channel" =>  get_channel_valid_attrs()})
     assert redirected_to(conn) == channel_path(conn, :index)
     assert Repo.get_by(Channel, get_channel_valid_attrs())
  end

  test "does not create resource and renders errors when data is invalid", %{conn: conn} do
    conn = conn
           |> admin_login
           |> action(:create, %{"channel" =>  get_invalid_attrs()})
    assert html_response(conn, 200) =~ "New channel"
  end

  test "shows chosen resource", %{conn: conn} do
    channel = Repo.insert! %Channel{}
    conn = conn
           |> admin_login
           |> action(:show, %{"id" => channel.id})

    assert html_response(conn, 200) =~ "Show channel"
  end

  test "renders form for editing chosen resource", %{conn: conn} do
    channel = Repo.insert! %Channel{}
    conn = conn
           |> admin_login
           |> action(:edit, %{"id" => channel.id})
    assert html_response(conn, 200) =~ "Edit channel"
  end

  test "updates chosen resource and redirects when data is valid", %{conn: conn} do
    channel = Repo.insert! %Channel{}
    conn = conn
           |> admin_login
           |> action(:update, %{"id" => channel.id, "channel" => get_channel_valid_attrs()})
    assert redirected_to(conn) == channel_path(conn, :index)
    assert Repo.get_by(Channel, get_channel_valid_attrs())
  end

  test "does not update chosen resource and renders errors when data is invalid", %{conn: conn} do
    channel = Repo.insert! %Channel{}
    conn = conn
           |> admin_login
           |> action(:update, %{"id" => channel.id, "channel" => get_invalid_attrs()})
    assert html_response(conn, 200) =~ "Edit channel"
  end

  test "deletes chosen resource", %{conn: conn} do
    channel = Repo.insert! %Channel{}
    conn = conn
           |> admin_login
           |> action(:delete, %{"id" => channel.id})
    assert redirected_to(conn) == channel_path(conn, :index)
    refute Repo.get(Channel, channel.id)
  end

end
