defmodule FileCommand do

  def read(input) do
    case File.read(input) do
      {:ok, body} -> body |> String.split("\n")
      _ -> []
    end
  end

  def read_string(input) do
      case File.read(input) do
        {:ok, body} -> body
        _ -> ""
      end
  end

  def read() do
      []
  end

  def read_json(input, pattern) do
    FileCommand.read(input)
    |> Enum.filter(fn(line) ->
      Regex.match?(pattern, line)
    end)
    |> Enum.map(fn(line) ->
       case Poison.decode line do
         {:ok, body} -> body
         _ -> %{}
       end
    end)
  end

  def read_json(input) do
    FileCommand.read(input)
    |> Enum.map(fn(line) ->
       case Poison.decode line do
         {:ok, body} -> body
         _ -> %{}
       end
    end)
  end

  def write(content, path) do
    File.write(path, content)
  end

  def write_json(content, path) do
      content
      |> Enum.map(fn(line) ->
         case Poison.encode line do
           {:ok, body} -> body
           _ -> %{}
         end
      end)
      |> Enum.join("\n")
      |> FileCommand.write(path)
  end

end