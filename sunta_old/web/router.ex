defmodule Sunta.Router do
  @moduledoc false
  use Sunta.Web, :router

  pipeline :browser do
    plug :accepts, ["html"]
    plug :fetch_session
    plug :fetch_flash
    plug :protect_from_forgery
    plug :put_secure_browser_headers
    plug :put_current_user
    plug :put_access_level
  end

  pipeline :api do
    plug :accepts, ["json"]
  end

  pipeline :admin_layout do
      plug :put_layout, {Sunta.LayoutView, :admin}
  end

  pipeline :login_layout do
        plug :put_layout, {Sunta.LayoutView, :login}
    end

  # admin root no auth
  scope "/admin", Sunta do
    pipe_through [:browser, :login_layout]

    get "/login", AuthController, :index
    post "/login", AuthController, :login
    get "/logout", AuthController, :logout
  end

  # admin root auth
  scope "/admin", Sunta.Admin do
    pipe_through [:browser, :admin_layout, :authenticate_user]

    get "/", HomeController, :index
    post "/reset_password/:id", UserController, :reset_password
    get "/profile", UserController, :profile
    put "/profile/edit", UserController, :profile_edit
    resources "/users", UserController
    resources "/channels", ChannelController
  end

  # page root
  scope "/", Sunta do
    pipe_through :browser

    get "/", PageController, :home

    scope "/:channel" do
      get "/", PageController, :channel

        scope "/:leaf" do
          get "/", PageController, :leaf
        end
    end
  end

  # Other scopes may use custom stacks.
  # scope "/api", Sunta do
  #   pipe_through :api
  # end
end
