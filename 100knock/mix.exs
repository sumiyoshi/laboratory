defmodule Mixfile do
  use Mix.Project

  def project do
    [app: :knock,
     version: "0.0.1",
     elixir: "1.3.4",
     deps: deps(),
     elixirc_paths: elixirc_paths()]
  end

  defp elixirc_paths(), do: ["lib", "task"]

  defp deps do
      [
       {:poison, "~> 1.5"},
       {:exkanji, "~> 0.3.1"}
      ]
    end
end
