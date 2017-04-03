defmodule Sunta.ChannelTest do
  use Sunta.ModelCase

  alias Sunta.Channel

  test "changeset with valid attributes" do
    changeset = Channel.changeset(%Channel{}, get_channel_valid_attrs())
    assert changeset.valid?
  end

  test "changeset with invalid attributes" do
    changeset = Channel.changeset(%Channel{}, get_invalid_attrs())
    refute changeset.valid?
  end
end
