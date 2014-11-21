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
class StringHttpRequest extends AbstractHttpRequest
{
    private $isXmlHttpRequest;
    private $isJsonRequest;
    private $method;
    private $serverAddress;
    private $clientAddress;
    private $userAgent;

    /**
     * @param string $url
     */
    public function __construct($url = '')
    {
        $parsedUrl = parse_url($url);

        $this->protocol = isset($parsedUrl['scheme']) ? strtolower($parsedUrl['scheme']) : '';
        $isHttps = substr($this->protocol, -1) === 's';
        $this->port = isset($parsedUrl['port']) ? (int) $parsedUrl['port'] : ($isHttps ? 443 : 80);
        $this->host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $this->path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $this->queryData);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isXmlHttpRequest()
    {
        return $this->isXmlHttpRequest;
    }

    /**
     * @param bool $isXmlHttpRequest
     */
    public function setXmlHttpRequest($isXmlHttpRequest)
    {
        $this->isXmlHttpRequest = (bool) $isXmlHttpRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function isJsonRequest()
    {
        return $this->isJsonRequest;
    }

    /**
     * @param bool $isJsonRequest
     */
    public function setJsonRequest($isJsonRequest)
    {
        $this->isJsonRequest = (bool) $isJsonRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function isPost()
    {
        return strtolower($this->method) === 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @throws \InvalidArgumentException
     */
    public function setMethod($method)
    {
        $method = (string) $method;
        if ($method === '') {
            throw new \InvalidArgumentException('$method cannot be empty');
        }

        $this->method = $method;
    }

    /**
     * {@inheritdoc}
     */
    public function getServerAddress()
    {
        return $this->serverAddress;
    }

    /**
     * @param string $serverAddress
     *
     * @throws \InvalidArgumentException
     */
    public function setServerAddress($serverAddress)
    {
        $serverAddress = (string) $serverAddress;
        if ($serverAddress === '') {
            throw new \InvalidArgumentException('$serverAddress cannot be empty');
        }

        $this->serverAddress = $serverAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientAddress()
    {
        return $this->clientAddress;
    }

    /**
     * @param string $clientAddress
     *
     * @throws \InvalidArgumentException
     */
    public function setClientAddress($clientAddress)
    {
        $clientAddress = (string) $clientAddress;
        if ($clientAddress === '') {
            throw new \InvalidArgumentException('$clientAddress cannot be empty');
        }

        $this->clientAddress = $clientAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     *
     * @throws \InvalidArgumentException
     */
    public function setUserAgent($userAgent)
    {
        $userAgent = (string) $userAgent;
        if ($userAgent === '') {
            throw new \InvalidArgumentException('$userAgent cannot be empty');
        }

        $this->userAgent = $userAgent;
    }
}
