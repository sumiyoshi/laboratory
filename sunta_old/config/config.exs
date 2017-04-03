# This file is responsible for configuring your application
# and its dependencies with the aid of the Mix.Config module.
#
# This configuration file is loaded before any dependency and
# is restricted to this project.
use Mix.Config

# General application configuration
config :sunta,
  ecto_repos: [Sunta.Repo]

# Configures the endpoint
config :sunta, Sunta.Endpoint,
  url: [host: "localhost"],
  secret_key_base: "kiL1utd+f1WmSP0S3ArLT0nomib0VYCRtAbUGrtI/T/aQrs4kIms1OV/dS57xeyh",
  render_errors: [view: Sunta.ErrorView, accepts: ~w(html json)],
  pubsub: [name: Sunta.PubSub,
           adapter: Phoenix.PubSub.PG2]

config :sunta, Sunta.Gettext,
  default_locale: "ja"

config :phoenix, :template_engines,
  slim: PhoenixSlime.Engine,
  slime: PhoenixSlime.Engine

# Import environment specific config. This must remain at the bottom
# of this file so it overrides the configuration defined above.
import_config "#{Mix.env}.exs"

