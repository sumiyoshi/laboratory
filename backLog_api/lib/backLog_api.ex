defmodule BackLogApi do

  @backlog_api_url "https://%{space_name}.backlog.jp/api/v2/%{endpoint}?apiKey=%{api_key}"

  @spec call(String.t, Atom.t) :: {Atom.t, Map.t}
  def call(url, method) do
    url
    |> do_request(method)
    |> do_response_decode
    |> do_cast_response
  end

  @spec get_request_url(String.t) :: String.t
  def get_request_url(endpoint) do
    @backlog_api_url
    |> String.replace("%{endpoint}", endpoint)
    |> String.replace("%{space_name}", Application.get_env(:backLog_api, :space_name))
    |> String.replace("%{api_key}", Application.get_env(:backLog_api, :api_key))
  end

  @spec do_request(String.t, Atom.t) :: HTTPoison.Response.t
  defp do_request(url, :get) do
    HTTPoison.get!(url)
  end

#  defp do_request(url, :post) do
#    HTTPoison.post!(url)
#  end

#  defp do_request(url, :put) do
#    HTTPoison.put!(url)
#  end

#  defp do_request(url, :patch) do
#    HTTPoison.patch!(url)
#  end

#  defp do_request(url, :delete) do
#    HTTPoison.delete!(url)
#  end

  @spec do_response_decode(HTTPoison.Response.t) :: Tuple.t
  defp do_response_decode(%HTTPoison.Response{body: body}), do: {Poison.decode!(body)}

  defp do_response_decode(response), do: response

  @spec do_cast_response(Tuple.Response.t) :: {Atom.t, Map.t}
  defp do_cast_response({%{"errors" => errors}}), do: {:error, errors}

  defp do_cast_response({response}), do: {:ok, response}
end
