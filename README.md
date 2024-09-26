# Westech
Stack: PHP, MySQL, Docker

## Running the project
```bash
$ docker compose build
$ docker compose up
```

This will run php server with mysql server - fixtures will be loaded from `fixtures` folder.

## Endpoints

### GET /products
Returns all products. You can use `offset` query parameter to get a specific page. (limit 10 products per page)

### POST /products
Creates a new product. You need to send a json body with the following fields:

- name
- description
- brand
- category
- price

### PATCH /products
Updates a product. You need to send a json body with the following fields:

- id
- name
- description
- brand
- category
- price

### DELETE /products/
Deletes a product. You need to send a json body with the following fields:	

- id

### GET /products/matchClosest
Returns the closest product to the given price.

- price

### Trying it out
Bearer Token `iw4.8/8Y8ymjw` needs to be used for PATH, POST, DELETE requests.

I decided not to use JWT because I wanted to keep it simple (and without libraries).

### Why is there composer?
Because I'm lazy and I don't want use require / require_once.
