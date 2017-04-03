defmodule Sunta.ChannelTasks do
  use Sunta.Web, :tasks

  alias Sunta.Channel
  alias Sunta.QueryHelper
  alias Sunta.Pagination.Navigation

  @limit 10

  @doc """
  Channel insert
  """
  def insert(params) do
    changeset = Channel.changeset(%Channel{}, params)
    Repo.insert(changeset)
  end

  @doc """
  Channel update
  """
  def update(id, params) do
    channel = Repo.get!(Channel, id)
    changeset = Channel.changeset(channel, params)

    case Repo.update(changeset) do
      {:ok, channel} -> {:ok, channel}
      {:error, changeset} -> {:error, changeset, channel}
    end
  end

  @doc """
  Channel search
  """
  def select(params) do
    query = Channel |> add_where(Potion.trim(params))

    page = Potion.get(params, "page", "1") |> Potion.to_integer
    limit = @limit
    offset = @limit * (page - 1)

    count = Repo.one(QueryHelper.get_count_query(query))
    channels =  query |> limit(^limit) |> offset(^offset) |> Repo.all()
    navigation = Navigation.get(count: count, current_page: page, limit: limit)

    %{channels: channels, navigation: navigation}
  end

  defp add_where(query, items) do
    QueryHelper.add_where(query, items, fn(query, key, value) ->
      case key do
        "title_like" -> where(query, [u], like(u.title, ^("#{value}%")))
        "channel_key_like" -> where(query, [u], like(u.channel_key, ^("#{value}%")))
        _ -> query
      end
    end)
  end

end
