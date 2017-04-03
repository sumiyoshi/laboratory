defmodule Sunta.PageController do
  @moduledoc false
  use Sunta.Web, :controller

  alias Sunta.Channel
  alias Sunta.ControllerHelper

  def home(conn, _) do
    channel = Channel |> Repo.get_by(channel_key: "home")

    if Potion.empty?(channel) do
      ControllerHelper.not_found(conn)
    else
      render conn, "channel.html", [channel: channel, title: channel.title]
    end
  end

  def channel(conn, %{"channel" => channel_key}) do
    channel = Channel |> Repo.get_by(channel_key: channel_key)

    if Potion.empty?(channel) do
      ControllerHelper.not_found(conn)
    else
      render conn, "channel.html", [channel: channel, title: channel.title]
    end
  end

  def leaf(conn, %{"channel" => channel, "leaf" => leaf}) do
    render conn, "leaf.html", [channel: channel, leaf: leaf]
  end
end
