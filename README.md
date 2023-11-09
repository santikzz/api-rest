Method  | Endpoint | Description | Parameters | Auth
------------- | ------------- | ------------- | ------------- | -------------
`GET`  | api/movies  | List all items | orderby, order, limit, offset | none
`GET`  | api/movies/:ID  | Get item by id | n/a | none
`GET`  | api/movies/genre/:GENRE | List all items by category | orderby, order, limit, offset | none
`POST` | api/movies/add | Add new item | name*, author*, genre*, image* | JWT
`PUT` | api/movies/edit | Edit item | id*, name*, author*, genre_id*, image* | JWT
`GET` | api/user/token | Get user access token | username*, password* | Basic bearer

Parameters with (*) are required


# Examples
---------------
#### GET /movies: `https://example.com/api/movies`
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

#### GET /movies/id/:ID : `https://example.com/api/movies/2`
```json
{
    "id": 2,
    "nombre": "Indiana Jones",
    "autor": "Steven Spielberg",
    "genero": "Action",
    "image": "https://example.com/images/2.jpg"
}
```

#### GET /movies/movies/genre/:GENRE : `https://example.com/api/movies/genre/suspense`
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

#### GET /movies/genres : `https://example.com/api/genres`
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

