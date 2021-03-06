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
class LanguageSubdomainResolver implements ResolverInterface
{
    private $languages;
    private $defaultLanguage;

    /**
     * @param array $languages
     */
    public function __construct(array $languages, $defaultLanguage = null)
    {
        $this->languages = $languages;
        $this->defaultLanguage = $defaultLanguage;
    }

    /**
     * @param HttpRequestInterface $httpRequest
     */
    public function resolve(HttpRequestInterface $httpRequest)
    {
        $httpRequest->setDefaultLanguage($this->defaultLanguage);
        $httpRequest->setUrlPattern('{protocol}://{language}.{host}:{port}{baseUrl}{path}', '{baseUrl}{path}');

        $hostExploded = explode('.', $httpRequest->getHost());
        if (!$hostExploded) {
            if ($this->defaultLanguage) {
                $httpRequest->setLanguage($this->defaultLanguage);
            }

            return;
        }

        $intersect = current(array_intersect($hostExploded, $this->languages));
        if (!$intersect) {
            if ($this->defaultLanguage) {
                $httpRequest->setLanguage($this->defaultLanguage);
            }

            return;
        }

        $httpRequest->setLanguage($intersect);
    }
}
