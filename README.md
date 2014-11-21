# HTTP Component - Mendo Framework

## HTTP Request

```Mendo\Http\Request``` 

* encapsulates the request information and provides a **fluent API** for easy access.
* allows you to automatically **find the language and base URL** using *resolvers*.
* allows you to **generate a URL** based on the request information.

### API

```php
public function setProtocol($protocol);
public function getProtocol();
public function isHttps();

public function setHost($host);
public function getHost();

public function setPort($port);
public function getPort();

public function setPath($path);
public function getPath();

public function setQueryData(array $data);
public function getQueryData();

public function hasQuery($name);
public function getQuery(...$args);

public function setPostData(array $data);
public function getPostData();

public function hasPost($name);
public function getPost(...$args);

public function setBaseUrl($baseUrl);
public function getBaseUrl();

public function setLanguage($language);
public function getLanguage();

public function isDefaultLanguage();
public function setDefaultLanguage($language);
public function getDefaultLanguage();

public function isXmlHttpRequest();

public function isAjax();

public function isJsonRequest();

public function isPost();

public function getMethod();

public function getServerAddress();

public function getClientAddress();

public function getUserAgent();

public function getUrl($absolute = false);
public function setUrlPattern($absoluteUrlPattern, $relativeUrlPattern);
```

### Language and Base URL Resolvers

The Language and Base URL Resolvers allow you to find the language and base URL automatically based on the URL.

```php
// example requested URL: http://localhost/myProject/fr/some/path

$request = new Mendo\Http\Request\HttpRequest();

(new BaseUrlAutoResolver())->resolve($request);

$languages = ['fr', 'nl', 'en']; // possible languages
$defaultLanguage = 'en';
(new LanguageSubdomainResolver($languages, $defaultLanguage))->resolve($request);

$request->getBaseUrl(); // returns "/myProject"

$request->getLanguage(); // returns "fr"
```

### Generate a URL

You can change all parts of the URL and generate the new URL:

```php
// example requested URL: http://localhost/some/path

$request = new Mendo\Http\Request\HttpRequest();

$request->setPath('/hello/world');

$request->getUrl(); // returns http://localhost/hello/world
```

## Installation

You can install Mendo HTTP using the dependency management tool [Composer](https://getcomposer.org/).
Run the *require* command to resolve and download the dependencies:

```
composer require mendoframework/http
```