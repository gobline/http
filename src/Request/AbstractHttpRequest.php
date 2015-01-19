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
abstract class AbstractHttpRequest implements HttpRequestInterface
{
    protected $absoluteUrlPattern = '{protocol}://{host}:{port}/{language}{baseUrl}{path}';
    protected $relativeUrlPattern = '/{language}{baseUrl}{path}';
    protected $protocol;
    protected $host;
    protected $port;
    protected $path;
    protected $queryData = [];
    protected $postData = [];
    protected $baseUrl;
    protected $language;
    protected $defaultLanguage;

    /**
     * {@inheritdoc}
     */
    public function setUrlPattern($absoluteUrlPattern, $relativeUrlPattern)
    {
        $absoluteUrlPattern = (string) $absoluteUrlPattern;
        if ($absoluteUrlPattern === '') {
            throw new \InvalidArgumentException('$absoluteUrlPattern cannot be empty');
        }

        $relativeUrlPattern = (string) $relativeUrlPattern;
        if ($relativeUrlPattern === '') {
            throw new \InvalidArgumentException('$relativeUrlPattern cannot be empty');
        }

        $this->absoluteUrlPattern = $absoluteUrlPattern;
        $this->relativeUrlPattern = $relativeUrlPattern;
    }

    /**
     * {@inheritdoc}
     */
    public function setProtocol($protocol)
    {
        $protocol = (string) $protocol;
        if ($protocol === '') {
            throw new \InvalidArgumentException('$protocol cannot be empty');
        }

        $this->protocol = $protocol;
    }

    /**
     * {@inheritdoc}
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * {@inheritdoc}
     */
    public function isHttps()
    {
        return substr($this->protocol, -1) === 's';
    }

    /**
     * {@inheritdoc}
     */
    public function setHost($host)
    {
        $host = (string) $host;
        if ($host === '') {
            throw new \InvalidArgumentException('$host cannot be empty');
        }

        $this->host = $host;
    }

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * {@inheritdoc}
     */
    public function setPort($port)
    {
        $this->port = (int) $port;
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->path = (string) $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setQueryData(array $data)
    {
        $this->queryData = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function setPostData(array $data)
    {
        $this->postData = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = (string) $baseUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguage($language)
    {
        $language = (string) $language;
        if ($language === '') {
            throw new \InvalidArgumentException('$language cannot be empty');
        }

        $this->language = $language;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * {@inheritdoc}
     */
    public function isDefaultLanguage()
    {
        return $this->defaultLanguage && $this->defaultLanguage === $this->language;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultLanguage($language)
    {
        $language = (string) $language;
        if ($language === '') {
            throw new \InvalidArgumentException('$language cannot be empty');
        }

        $this->defaultLanguage = $language;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function isXmlHttpRequest();

    /**
     * {@inheritdoc}
     */
    public function isAjax()
    {
        return $this->isXmlHttpRequest();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function isJsonRequest();

    /**
     * {@inheritdoc}
     */
    abstract public function isPost();

    /**
     * {@inheritdoc}
     */
    abstract public function getMethod();

    /**
     * {@inheritdoc}
     */
    abstract public function getServerAddress();

    /**
     * {@inheritdoc}
     */
    abstract public function getClientAddress();

    /**
     * {@inheritdoc}
     */
    abstract public function getUserAgent();

    /**
     * {@inheritdoc}
     */
    public function hasQuery($name)
    {
        if ((string) $name === '') {
            throw new \InvalidArgumentException('$name cannot be empty');
        }

        return array_key_exists($name, $this->queryData);
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery(...$args)
    {
        switch (count($args)) {
            default:
                throw new \InvalidArgumentException('getQuery() takes two arguments maximum');
            case 0:
                return $this->queryData;
            case 1:
                if (!$this->hasQuery($args[0])) {
                    throw new \InvalidArgumentException('Query string parameter "'.$args[0].'" not found');
                }

                return $this->queryData[$args[0]];
            case 2:
                if (!$this->hasQuery($args[0])) {
                    return $args[1];
                }

                return $this->queryData[$args[0]];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasPost($name)
    {
        if ((string) $name === '') {
            throw new \InvalidArgumentException('$name cannot be empty');
        }

        return array_key_exists($name, $_POST);
    }

    /**
     * {@inheritdoc}
     */
    public function getPost(...$args)
    {
        switch (count($args)) {
            default:
                throw new \InvalidArgumentException('getPost() takes two arguments maximum');
            case 0:
                return $this->postData;
            case 1:
                if (!$this->hasPost($args[0])) {
                    throw new \InvalidArgumentException('Post parameter "'.$args[0].'" not found');
                }

                return $this->postData[$args[0]];
            case 2:
                if (!$this->hasPost($args[0])) {
                    return $args[1];
                }

                return $this->postData[$args[0]];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($absolute = false)
    {
        $displayLanguage = $this->language && !$this->isDefaultLanguage();

        $placeholders = [
            '{protocol}:' => !$this->protocol ? '' : $this->protocol.':',
            '{host}' => $this->host,
            ':{port}' => (!$this->isHttps() && $this->port == 80) || ($this->isHttps() && $this->port == 443) ? '' : ':'.$this->port,
            '{language}.' => $displayLanguage ? $this->language.'.' : '',
            '/{language}' => $displayLanguage ? '/'.$this->language : '',
            '{baseUrl}' => $this->baseUrl ? $this->baseUrl : '',
            '{path}' => $this->path,
        ];

        $format = $absolute ? $this->absoluteUrlPattern : $this->relativeUrlPattern;

        $url = str_replace(array_keys($placeholders), $placeholders, $format);

        $prefix = '?';
        foreach ($this->queryData as $key => $value) {
            $url .= $prefix.$key.'='.rawurlencode($value);
            $prefix = '&';
        }

        if (!$absolute && $url === '') {
            $url = '/';
        }

        return $url;
    }
}
