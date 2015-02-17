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
class LanguageSubdirectoryResolver implements ResolverInterface
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
        if ($this->defaultLanguage) {
            $httpRequest->setDefaultLanguage($this->defaultLanguage);
        }

        $path = $httpRequest->getPath();

        $pathExploded = array_filter(explode('/', $path));
        if (!$pathExploded) {
            if ($this->defaultLanguage) {
                $httpRequest->setLanguage($this->defaultLanguage);
            }

            return;
        }

        $language = array_shift($pathExploded);

        if (in_array($language, $this->languages)) {
            $httpRequest->setLanguage($language);
            $httpRequest->setPath('/'.implode('/', $pathExploded));
        } elseif($this->defaultLanguage) {
            $httpRequest->setLanguage($this->defaultLanguage);
        }
    }
}
