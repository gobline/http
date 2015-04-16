<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Http\Request\Resolver;

use Mendo\Http\Request\HttpRequestInterface;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class BaseUrlResolver implements ResolverInterface
{
    private $baseUrl;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = (string) $baseUrl;
    }

    /**
     * @param HttpRequestInterface $httpRequest
     */
    public function resolve(HttpRequestInterface $httpRequest)
    {
        $baseUrl = rtrim($this->baseUrl, '/');
        $httpRequest->setBaseUrl($baseUrl);

        $baseUrl.='/';
        $pos = strpos($_SERVER['REQUEST_URI'], $baseUrl);
        if ($pos === 0) {
            $httpRequest->setPath('/'.substr_replace($_SERVER['REQUEST_URI'], '', $pos, strlen($baseUrl)));
        }
    }

    /**
     * @param string $a
     * @param string $b
     */
    private function getIntersection($a, $b)
    {
        $result = '';
        $len = min(strlen($a), strlen($b));
        for ($i = 0; $i < $len; ++$i) {
            if ($a[$i] != $b[$i]) {
                break;
            }
            $result .= $a[$i];
        }

        return $result;
    }
}