defmodule Sunta.Admin.ChannelController do
  @moduledoc false
  use Sunta.Web, :controller

  alias Sunta.Channel
  alias Sunta.ChannelTasks

  def index(conn, %{"search" => search_params}) do
    %{channels: channels, navigation: navigation} = ChannelTasks.select(search_params)
    render(conn, "index.html", channels: channels, navigation: navigation, search_params: search_params)
  end

  def index(conn, _params) do
    %{channels: channels, navigation: navigation} = ChannelTasks.select(%{})
    render(conn, "index.html", channels: channels, navigation: navigation, search_params: %{})
  end

  def new(conn, _params) do
    changeset = Channel.changeset(%Channel{})
    render(conn, "new.html", changeset: changeset)
  end

  def create(conn, %{"channel" => channel_params}) do
    case ChannelTasks.insert(channel_params) do
      {:ok, _channel} ->
        conn
        |> put_flash(:info, "Channel created successfully.")
        |> redirect(to: channel_path(conn, :index))
      {:error, changeset} ->
        render(conn, "new.html", changeset: changeset)
    end
  end

  def show(conn, %{"id" => id}) do
    channel = Repo.get!(Channel, id)
    render(conn, "show.html", channel: channel)
  end

  def edit(conn, %{"id" => id}) do
    channel = Repo.get!(Channel, id)
    changeset = Channel.changeset(channel)
    render(conn, "edit.html", channel: channel, changeset: changeset)
  end

  def update(conn, %{"id" => id, "channel" => channel_params}) do
    case ChannelTasks.update(id, channel_params) do
      {:ok, _channel} ->
        conn
        |> put_flash(:info, "Channel updated successfully.")
        |> redirect(to: channel_path(conn, :index))
      {:error, changeset, channel} ->
        render(conn, "edit.html", channel: channel, changeset: changeset)
    end
  end

  def delete(conn, %{"id" => id}) do
    channel = Repo.get!(Channel, id)

    # Here we use delete! (with a bang) because we expect
    # it to always work (and if it does not, it will raise).
    Repo.delete!(channel)

    conn
    |> put_flash(:info, "Channel deleted successfully.")
    |> redirect(to: channel_path(conn, :index))
  end
end
