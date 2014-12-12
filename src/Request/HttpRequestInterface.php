<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Http\Request;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
interface HttpRequestInterface
{
    /**
     * This method allows you to specify the format of the URL to generate when using getUrl().
     * The default format is the following:
     * {protocol}://{host}:{port}/{language}{baseUrl}{path}
     * For example, if you want instead to have the language specified as a subdomain,
     * you can change the format with this method to the following:
     * {protocol}://{language}.{host}:{port}{baseUrl}{path}
     *
     * @param string $absoluteUrlPattern
     * @param string $relativeUrlPattern
     *
     * @throws \InvalidArgumentException
     */
    public function setUrlPattern($absoluteUrlPattern, $relativeUrlPattern);

    /**
     * @param string $protocol
     *
     * @throws \InvalidArgumentException
     */
    public function setProtocol($protocol);

    /**
     * @return string
     */
    public function getProtocol();

    /**
     * @return bool
     */
    public function isHttps();

    /**
     * @param string $host
     *
     * @throws \InvalidArgumentException
     */
    public function setHost($host);

    /**
     * @return string $absoluteUrlPattern
     */
    public function getHost();

    /**
     * @param int $port
     */
    public function setPort($port);

    /**
     * @return int
     */
    public function getPort();

    /**
     * @param string $path
     */
    public function setPath($path);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param array $data
     */
    public function setQueryData(array $data);

    /**
     * @return array
     */
    public function getQueryData();

    /**
     * @param array $data
     */
    public function setPostData(array $data);

    /**
     * @return array
     */
    public function getPostData();

    /**
     * @param string $baseUrl
     *
     * @throws \InvalidArgumentException
     */
    public function setBaseUrl($baseUrl);

    /**
     * @return string
     */
    public function getBaseUrl();

    /**
     * @param string $language
     *
     * @throws \InvalidArgumentException
     */
    public function setLanguage($language);

    /**
     * @return string
     */
    public function getLanguage();

    /**
     * @return bool
     */
    public function isDefaultLanguage();

    /**
     * @param string $language
     *
     * @throws \InvalidArgumentException
     */
    public function setDefaultLanguage($language);

    /**
     * @return string
     */
    public function getDefaultLanguage();

    /**
     * @return bool
     */
    public function isXmlHttpRequest();

    /**
     * @return bool
     */
    public function isAjax();

    /**
     * @return bool
     */
    public function isJsonRequest();

    /**
     * @return bool
     */
    public function isPost();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getServerAddress();

    /**
     * @return string
     */
    public function getClientAddress();

    /**
     * @return string
     */
    public function getUserAgent();

    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function hasQuery($name);

    /**
     * This method takes one or two arguments.
     * The first argument is the query string variable you want to get.
     * The second optional argument is the default value you want to get back
     * in case the query string hasn't been found.
     * If the second argument is omitted and the variable
     * hasn't been found, an exception will be thrown.
     *
     * @param mixed $args
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function getQuery(...$args);

    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function hasPost($name);

    /**
     * This method takes one or two arguments.
     * The first argument is the post variable you want to get.
     * The second optional argument is the default value you want to get back
     * in case the post variable hasn't been found.
     * If the second argument is omitted and the variable
     * hasn't been found, an exception will be thrown.
     *
     * @param mixed $args
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function getPost(...$args);

    /**
     * @param bool $absolute
     *
     * @return string
     */
    public function getUrl($absolute = false);
}
