defmodule BackLogApi do

  @backlog_api_url "https://%{space_name}.backlog.jp/api/v2/%{endpoint}?apiKey=%{api_key}"

  @type headers :: [{binary, binary}] | %{binary => binary}
  @type body :: binary | {:form, [{atom, any}]} | {:file, binary}

  @spec get(binary, headers, Keyword.t) :: {Atom.t, Map.t}
  def get(url, headers \\ [], options \\ []) do
    url
    |> HTTPoison.get!(headers, options)
    |> do_response_decode
    |> do_cast_response
  end

  @spec put(binary, Map.t, headers, Keyword.t) :: {Atom.t, Map.t}
  def put(url, body, headers \\ [], options \\ []) do
    url
    |> HTTPoison.put!(body, headers, options)
    |> do_response_decode
    |> do_cast_response
  end

  @spec post(binary, body, headers, Keyword.t) :: {Atom.t, Map.t}
  def post(url, body, headers \\ [], options \\ []) do
    url
    |> HTTPoison.post!(body, headers, options)
    |> do_response_decode
    |> do_cast_response
  end

  @spec patch(binary, body, headers, Keyword.t) :: {Atom.t, Map.t}
  def patch(url, body, headers \\ [], options \\ []) do
    url
    |> HTTPoison.patch!(body, headers, options)
    |> do_response_decode
    |> do_cast_response
  end

  @spec delete(binary, headers, Keyword.t) :: {Atom.t, Map.t}
  def delete(url, headers \\ [], options \\ []) do
    url
    |> HTTPoison.delete!(headers, options)
    |> do_response_decode
    |> do_cast_response
  end

  @spec get_request_url(binary) :: binary
  def get_request_url(endpoint) do
    @backlog_api_url
    |> String.replace("%{endpoint}", endpoint)
    |> String.replace("%{space_name}", Application.get_env(:backLog_api, :space_name))
    |> String.replace("%{api_key}", Application.get_env(:backLog_api, :api_key))
  end

  @spec do_response_decode(HTTPoison.Response.t) :: Tuple.t
  defp do_response_decode(%HTTPoison.Response{body: body}), do: {Poison.decode!(body)}

  defp do_response_decode(response), do: response

  @spec do_cast_response(Tuple.Response.t) :: {Atom.t, Map.t}
  defp do_cast_response({%{"errors" => errors}}), do: {:error, errors}

  defp do_cast_response({response}), do: {:ok, response}
end
