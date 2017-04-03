# phoenix_docker


##GET STARTED

Change hostname of databese to postgres-db

Dependence Install

```
docker-compose run web npm install
docker-compose run web npm run deploy
docker-compose run web mix deps.get
```

Create Database

```
docker-compose run web mix ecto.create 
```

Starting the server

```
docker-compose up -d
```

