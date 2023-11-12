Method  | Endpoint | Description | Parameters | Auth
------------- | ------------- | ------------- | ------------- | -------------
`GET`  | api/movies  | List all movies | orderby, order, limit, offset | none
`GET`  | api/movies/:ID  | Get movie by id | n/a | none
`GET`  | api/movies/genre/:GENRE | List all movies by genre | orderby, order, limit, offset | none
`POST` | api/movies/add | Add new movie | name*, author*, genre*, image* | Bearer Token
`PUT` | api/movies/update | Edit movie | id*, name*, author*, genre_id*, image* | Bearer Token
`GET` | api/user/token | Get user access token | username*, password* | Basic bearer

Parameters with (*) are required
Default admin user ( username: **admin**, password: **admin**)

# Examples
---------------
#### GET `api/movies`
###### Optional GET Parameters
`orderby` (id, nombre, autor, genero)
`order` (asc, desc)
```api/movies?orderby=nombre&order=desc```

`limit` number
`offset` number
`api/movies?limit=10&offset=10`
```json
[
    {
        "id": 2,
        "nombre": "Indiana Jones",
        "autor": "Steven Spielberg",
        "genero": "Action",
        "image": "https://example.com/images/2.jpg"
    },
    {
        "id": 9,
        "nombre": "Back to the Future",
        "autor": "Steven Spielberg",
        "genero": "Fiction",
        "image": "https://example.com/images/9.jpg"
    },
...
```

#### GET `api/movies/id/:ID`
```json
{
    "id": 2,
    "nombre": "Indiana Jones",
    "autor": "Steven Spielberg",
    "genero": "Action",
    "image": "https://example.com/images/2.jpg"
}
```

#### GET `api/movies/movies/genre/:GENRE`
```json
[
    {
        "id": 13,
        "nombre": "Scary Movie",
        "autor": "Shawn Wayans",
        "image": "https://streamcoimg-a.akamaihd.net/000/136/9860/1369860-PosterArt-fbc02dce7486c2af10290978add8046a.jpg"
    }
]
```

#### GET `api/movies/genres`
```json
[
    {
        "id": 1,
        "nombre": "Action"
    },
    {
        "id": 3,
        "nombre": "Fiction"
    },
    {
        "id": 4,
        "nombre": "Suspense"
    },
    {
        "id": 6,
        "nombre": "Animation"
    },
    {
        "id": 11,
        "nombre": "Horror"
    }
]
```
#### POST `api/movies/add` 
Auth required* (Bearer token)
Required post parameters -> title, author, genre, image_url

#### POST `api/movies/update` 
Auth required* (Bearer Token) from `api/user/token`
Required post parameters -> id, title, author, genre, image_url

#### GET `api/user/token` 
Auth required* (Basic Auth)
Required post parameters -> id, title, author, genre, image_url
```json
{
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyaWQiOjEsInVzZXJuYW1lIjoiYWRtaW4iLCJpc0FkbWluIjoxLCJleHAiOjE2OTk4MzEzMTF9.Evl51F275ApPUeG0LQ4m8kCT6SDl8OF0bzYKKmyjdcw"
}
``` 