defmodule BackLogApiTest do
  use ExUnit.Case
  doctest BackLogApi

  test "the truth" do

    BackLogApi.get_request_url("users")
    |> IO.inspect()

    assert 1 + 1 == 2
  end
end
