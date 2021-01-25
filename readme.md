# Palindrome

## Description
Series of endpoints that returns if a word is a Palindrome or not.
## Installation

### 1) Docker
First, we need to install the Docker in our machine (if its already not). <br />

To check run this command:

To make sure docker is installed you can run this and it should return the docker version on your machine:

```
docker --version
```

And if Docker is not installed please install it from this page <a href="https://docs.docker.com/get-docker">Get Docker</a>

### 2) Clone the project
Make sure git is installed and clone the repo to your local by running:

```
git clone https://github.com/alifarhangmehr/palindrome.git
```

### 3) Docker-compose
Now its time to run the docker-compose command to start containers for: <br />
- Backend container: Apache2
- Front-end container: React
- DB container: MySQL
- Caching server container: Redis
- Swagger/OpenAPI container

All you need is to run this command for the first time (or if you need to rebuild the images):
```
docker-compose up --build
```
This is gonna take a while the first time. <br />

Next time, `--build` can be removed
```
docker-compose up
```

To make sure the containers are running you can run this command:
```
docker ps
```

The result should look like this: <br />
```
CONTAINER ID        IMAGE                   COMMAND                  CREATED             STATUS              PORTS                               NAMES
430153ae0833        aws-test_backend        "docker-php-entrypoi…"   45 seconds ago      Up 44 seconds       0.0.0.0:8000->80/tcp                palindrome
b537d0ca1130        mysql                   "docker-entrypoint.s…"   46 seconds ago      Up 36 seconds       0.0.0.0:3306->3306/tcp, 33060/tcp   mysql
fac6444eede1        swaggerapi/swagger-ui   "/docker-entrypoint.…"   46 seconds ago      Up 45 seconds       80/tcp, 0.0.0.0:8001->8080/tcp      swagger-ui
2dcfd2adf4cb        aws-test_react          "docker-entrypoint.s…"   46 seconds ago      Up 45 seconds       0.0.0.0:3000->3000/tcp              react
c08ba5b21cc5        redis                   "docker-entrypoint.s…"   46 seconds ago      Up 45 seconds       0.0.0.0:6379->6379/tcp              redis
```

All dockerfiles are in `Dockerfile` folder, feel free to change the configs for your own need. <br />

As the last step load this URL in the browser to create tables and do bare minimum seeding:
```
http://localhost:8000/reset_db
```

This also can be used whenever you decided to reset the DB to the initial state. <br />

Well that's it, enjoy!

## How to use
First for knowing the API input and outputs please check Swagger/OpenAPI:
```
http://localhost:8001
```

<img src="https://raw.githubusercontent.com/alifarhangmehr/palindrome/master/images/swagger.png">

You can "Try it out" with bearer token:
```
Bearer 8efe07b353ccb4e5515d2062cb1976bf4cfdbfada6ffaf3c005e2c1e1515e6db
```

<img src="https://raw.githubusercontent.com/alifarhangmehr/palindrome/master/images/swagger-execute.png">


There are a few ways to test this: <br />

### Postman
Now that you know what API ask for and what returns, let's try it out in the Postman: <br />
There is a postman export in `tests/Postman` that can easily be imported:
<img src="https://raw.githubusercontent.com/alifarhangmehr/palindrome/master/images/postman.png">

Headers and body already configured for convenience, but feel free to play around with them.

### React - front-end
The other way to call the APIs is through the front-end UI:
```
http://localhost:3000
```
<img src="https://raw.githubusercontent.com/alifarhangmehr/palindrome/master/images/react-1.png">
<img src="https://raw.githubusercontent.com/alifarhangmehr/palindrome/master/images/react-2.png">
<img src="https://raw.githubusercontent.com/alifarhangmehr/palindrome/master/images/react-3.png">

## Tests

### Postman API tests
I could have implement API testing in the app with Guzzle or similar API testing technologies, but due to time limitation instead, I used postman tests to verify response code and expected results. <br />

There are 37 tests that can be run in Postman (you should have them if already imported the postman file):

<img src="https://raw.githubusercontent.com/alifarhangmehr/palindrome/master/images/postman-api-test.png">

Or alternatively by command line: <br />

1) First `newman` needs to be installed:
```
npm install -g newman
```

For more information you can check this page: <a href="https://learning.postman.com/docs/running-collections/using-newman-cli/command-line-integration-with-newman/"> Postman Newman</a>

and then just run this command in the root folder:
```
newman run tests/Postaman/Palindrome.postman_collection.json 
```

The result should look like this:
```
Palindrome

❏ Palindromes
↳ Palindromes
  POST http://localhost:8000/v1/palindromes [200 OK, 535B, 212ms]

❏ Login
↳ Login
  POST http://localhost:8000/v1/login [200 OK, 799B, 44ms]

❏ Tests
↳ Palindromes - 200 - is a palindrome
  POST http://localhost:8000/v1/palindromes [200 OK, 534B, 110ms]
  ✓  Successful POST request
  ✓  Status in json reponse check
  ✓  Body matches string

↳ Palindromes - 200 - is not a plindrome
  POST http://localhost:8000/v1/palindromes [200 OK, 542B, 104ms]
  ✓  Successful POST request
  ✓  Status in json reponse check
  ✓  Body matches string

.
.
.

↳ Login - 400
  POST http://localhost:8000/v1/login [400 Bad Request, 544B, 55ms]
  ✓  Successful POST request
  ✓  Status in json reponse check
  ✓  Body matches string

❏ Users
↳ Users
  POST http://localhost:8000/v1/users [200 OK, 554B, 73ms]

↳ Users
  PATCH http://localhost:8000/v1/users [200 OK, 553B, 52ms]

┌─────────────────────────┬───────────────────┬───────────────────┐
│                         │          executed │            failed │
├─────────────────────────┼───────────────────┼───────────────────┤
│              iterations │                 1 │                 0 │
├─────────────────────────┼───────────────────┼───────────────────┤
│                requests │                18 │                 0 │
├─────────────────────────┼───────────────────┼───────────────────┤
│            test-scripts │                31 │                 0 │
├─────────────────────────┼───────────────────┼───────────────────┤
│      prerequest-scripts │                18 │                 0 │
├─────────────────────────┼───────────────────┼───────────────────┤
│              assertions │                37 │                 0 │
├─────────────────────────┴───────────────────┴───────────────────┤
│ total run duration: 1769ms                                      │
├─────────────────────────────────────────────────────────────────┤
│ total data received: 1.59KB (approx)                            │
├─────────────────────────────────────────────────────────────────┤
│ average response time: 73ms [min: 39ms, max: 212ms, s.d.: 39ms] │
└─────────────────────────────────────────────────────────────────┘

```
How cool is that :)

### PHPUnit Tests

The command to test needs to be executed inside the docker container:
```
docker exec -it palindrome /bin/bash
```

And then run:
```
./vendor/bin/phpunit tests/Unit
```

Since I didn't use dependency injection and loading the other classes in the constructor, Mocking the objects isn't an option that limits the method and classes that can be tested.

##How does it work?

Now that you tested the app lets take a look under the hood and see how it works:

### Routing

I made my own custom router logic and I tried to make it as simple as possible. <br />
I config apache2 to redirect every single request to `index.php` and pass all the parameters as an argument. <br />
That page loads the routes defined in `Router/Routes.php`. <br />
Let's take a look at one of the routes:
```php
$router->post('/v1/palindromes', function($request) {
    require_once 'Controller/PalindromeController.php';
    $palindromeController = new PalindromeController($request);
    return $palindromeController->isPalindrome($request);
});
```
First, we define what type of request this supposed to be and then the URL, lastly calling the method for this endpoint from the load controller. <br />

<img src="https://raw.githubusercontent.com/alifarhangmehr/palindrome/master/images/router-logic.jpg">

### Architecture
I decided to go with SOA architecture which is this case includes: <br />
1) Controllers
2) Services
3) Models
4) Helpers
5) Wrappers

I could have Flows, Gateways and etc, but based on the scale and time I decided not to add them. <br />
In this architecture, the Router calls the Controller and the controller calls the Service which uses the Model, Helper, and Wrappers to take care of the request.
This could have been Router->Controller->Flow->Service->Gateway if I was to add Flow and Gateway to my design.

### How it all works?

#### Palindromes
Controllers checks if the word is already cached, that's right I add a cache layer, and based on that either reads from the cache or calls the service and writes to the cache for the next time.

<img src="https://raw.githubusercontent.com/alifarhangmehr/palindrome/master/images/palindrome-flow.jpg">

Now you might ask why on earth you decided to add the caching layer? <br />
Well, I figured the isPalindrome logic is just a test, but in the real-world, the logic is usually more complicated and requires read from the DB, which in that case caching will increase the performance drastically.

#### Users
I also added a user and login endpoint to add authentication to the system by Bearer token. <br />
The decision for going with Bearer and not something like OAuth2 made due to the size of the project and time constraint. <br />

All endpoints except, login and create new user will require a valid bearer token as authentication. <br />
Tokens are in the user table, which is not the best way to store them, but it works for this task. <br />

In my tests, I used a token that already been seeded to the DB, in a real-world example, the user first needs to create an account and/or login with an existing one and get the token from the response of that and call palindromes endpoint with that token.
