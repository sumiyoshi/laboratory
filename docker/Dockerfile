########## OS ##########
FROM centos:centos7

RUN yum update -y && yum clean all
RUN yum reinstall -y glibc-common
########## OS ##########

########## ENV ##########
# Elixir requires UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Set app env
ENV HOME /root
########## ENV ##########

########## MIDDLEWARE ##########
WORKDIR /usr/local/src

RUN yum install -y gcc gcc-c++ make openssl-devel ncurses-devel && yum clean all
RUN yum install -y epel-release.noarch && yum clean all
RUN yum install -y http://packages.erlang-solutions.com/site/esl/esl-erlang/FLAVOUR_1_general/esl-erlang_18.1-1~centos~7_amd64.rpm && yum clean all
RUN yum install -y sudo wget git tar bzip2 incron vim nodejs npm && yum clean all
########## MIDDLEWARE ##########

########## ELIXIR ##########
ENV ELIXIR_VERSION 1.4.1

# Build Elixir
RUN git clone https://github.com/elixir-lang/elixir.git
WORKDIR /usr/local/src/elixir
RUN git checkout refs/tags/v${ELIXIR_VERSION}
RUN make clean install

########## ELIXIR ##########

# Install HEX
RUN mix local.hex --force && mix local.rebar --force

########## PHOENIXFRAMEWORK ##########
# Install original phoenixframework
RUN mkdir -p /usr/local/src/phoenix/origin
WORKDIR /usr/local/src/phoenix/origin
RUN git clone https://github.com/phoenixframework/phoenix.git
WORKDIR /usr/local/src/phoenix/origin/phoenix/installer
RUN MIX_ENV=prod mix archive.build
RUN yes | mix archive.install

# Install phoenix app
RUN mkdir -p /usr/local/src/phoenix/app
WORKDIR /usr/local/src/phoenix/app
########## PHOENIXFRAMEWORK ##########

