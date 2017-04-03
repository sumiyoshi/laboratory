defmodule Sunta.AttrsSupport do

  def get_login_id() do
    "login"
  end

  def get_admin_login_id() do
    "admin_user"
  end

  def get_password() do
    "password"
  end

  def get_admin_valid_attrs() do
    %{mail: "test@test.com", name: "some content", password: get_password(), login_id: get_admin_login_id(), administrator: true}
  end

  def get_user_valid_attrs() do
    %{mail: "test@test.com", name: "some content", password: get_password(), login_id: get_login_id(), administrator: true}
  end

  def get_public_user_valid_attrs() do
    %{mail: "test@test.com", name: "some content", password: get_password(), login_id: get_login_id(), administrator: false}
  end

  def get_user_serch_attrs() do
    %{mail: "test@test.com", name: "some content", login_id: get_login_id()}
  end

  def get_channel_valid_attrs() do
    %{channel_key: "some content", content: "some content", draft: true, release_date: %{day: 17, hour: 14, min: 0, month: 4, sec: 0, year: 2010}, title: "some content"}
  end

  def get_invalid_attrs() do
    %{}
  end

end
