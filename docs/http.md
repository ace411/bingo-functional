# bingo-functional-http

bingo-functional-http is a simple tool for sending and receiving data over Http. Inspired by the Haskell Http packages, this tool is one whose value is in allowing those who use it, a Functional Programming approach to handling the side-effects of Http responses.

To install the package, type the following in a console of your choosing:

```
composer require chemem/bingo-functional-http dev-master
```

**Note:** The library is built atop PHP streams and uses the certificates in the Composer CA bundle.

## Library Functions

### show function

```
show(object $http)
```

**Since:** v1.0.0

**Argument(s):**

- ***http (object)*** - One of either a Request or Response object

Output the contents of a Request or Response object as a string - a JSON string.

```php
use Chemem\Bingo\Functional\Http;
use Chemem\Bingo\Functional\Algorithms as A;

$request = A\compose(Http\getRequest, Http\show); //point-free style

print_r($request('https://example.com'));
//outputs Request object
```

### setHeaders

```
setHeaders(Request $request, array $headers)
```

**Since:** v1.0.0

**Argument(s):**

- ***request (Request)*** - Request object
- ***headers (array)*** - Request headers

Add headers to a Request object.

```php
...
const headers = array(
    'X-User: @agiroloki',
    'X-Package: bingo-functional-http'
);

$headers = A\compose(Http\gettRequest, A\partialRight(Http\setHeaders, headers));

print_r($headers('http://example.org')); 
```

### getHeaders

```
getHeaders(object $http)
```

**Since:** v1.0.0

**Argument(s):**

- ***http (object)*** - One of either a Request or Response object

Prints all Request/Response headers.

```php
...
$headers = A\compose(Http\getRequest, A\partialRight(Http\setHeaders, headers), Http\getHeaders); //point-free style

assert($headers('https://example.org') == headers, 'Headers are not the same'); //outputs array of headers
```

### setRequestBody

```
setRequestBody(Request $request, array $body)
```

**Since:** v1.0.0

**Argument(s):**

- ***request (Request)*** - Request object
- ***headers (array)*** - Request body

Adds a request body to a Request object.

```php
...
const body = array(
    'username' => 'ace411',
    'twitterHandle' => '@agiroLoki'
);

$body = A\compose(
    Http\postRequest, 
    A\partialRight(Http\setHeaders, array(
        'Content-Type: application/json',
        'Accept: application/json'
    )),
    A\partialRight(Http\setRequestBody, body)
);

print_r($body('http://somesite.com'));
```

### http

```
http(Request $request)
```

**Since:** v1.0.0

**Argument(s):**

- ***request (Request)*** - Request object

Analogous to Haskell's simpleHTTP function. Performs a request and returns a response.

```php
...
$request = A\compose(
    Http\getRequest,
    A\partialRight(Http\setHeaders, array(
        'Content-Type: application/json',
        'Accept: application/json'
    )),
    Http\http
);

$result = $request('https://api.publicapis.org/random')); //works with https

print_r($result);
```

### getResponseBody

```
getResponseBody(Response $response)
```

**Since:** v1.0.0

**Argument(s):**

- ***request (Request)*** - Response object

Outputs the body of a server response.

```php
use Chemem\Bingo\Functional\Functors\Monads as M;
use Chemem\Bingo\Functional\Functors\Monads\IO;

$body = A\compose($request, function (IO $response) {
    return M\bind(Http\getResponseBody, $response); //use bind on IO monad instance
});

print_r($body);
```


### getResponseCode

```
getResponseCode(Response $response)
```

**Since:** v1.0.0

**Argument(s):**

- ***request (Request)*** - Response object

Outputs the server response code. Check out the [list of response codes]().

```php
...
$body = A\compose($request, function (IO $response) {
    return M\bind(Http\getResponseCode, $response);
});

print_r($body);
```

### xRequest

```
get|put|post|headRequest(string $uri)
```

**Since:** v1.0.0

**Argument(s):**

- ***uri (string)*** - Server URI

Creates a request object with a single URI element.

```php
$request = Http\headRequest('https://example.com');
```

### postRequestWithBody

```
postRequestWithBody(string $uri, string $contentType, array $body)
```

**Since:** v1.0.0

**Argument(s):**

- ***uri (string)*** - Server URI
- ***contentType (string)*** - The media type of the resource
- ***body (array)*** - The body of the request

Constructs a request and sets the body as well as Content-Type header.

```php
$post = Http\postRequestWithBody('http://path/to/site', 'application/json', body);
```