FORMAT: 1A

# Yelp

# AppHttpControllersApiV1UserController
Class UserController

## User resource representation. [GET /users/{id}]


+ Parameters
    + page: (string, optional) - The page of results to view.
        + Default: 1
    + limit: (string, optional) - The amount of results per page.
        + Default: 10

+ Request (application/x-www-form-urlencoded)
    + Body

            username=foo&password=bar

+ Response 200 (application/json)
    + Body

            {
                "id": 10,
                "username": "foo"
            }