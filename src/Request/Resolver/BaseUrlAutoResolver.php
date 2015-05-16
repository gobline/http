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
class BaseUrlAutoResolver implements ResolverInterface
{
    /**
     * @param HttpRequestInterface $httpRequest
     */
    public function resolve(HttpRequestInterface $httpRequest)
    {
        $scriptPath = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $baseUrl = $this->getIntersection($scriptPath, $httpRequest->getPath());
        $httpRequest->setBaseUrl(rtrim($baseUrl, '/'));

        $pos = strpos($httpRequest->getPath(), $baseUrl);
        if ($pos === 0) {
            $httpRequest->setPath('/'.substr_replace($httpRequest->getPath(), '', $pos, strlen($baseUrl)));
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
