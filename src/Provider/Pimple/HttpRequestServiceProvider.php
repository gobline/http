<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Http\Provider\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Mendo\Http\Request\HttpRequest;
use Mendo\Http\Request\Resolver\BaseUrlAutoResolver;
use Mendo\Http\Request\Resolver\LanguageSubdirectoryResolver;
use Mendo\Http\Request\Resolver\LanguageSubdomainResolver;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class HttpRequestServiceProvider implements ServiceProviderInterface
{
    private $reference;

    public function __construct($reference = 'request')
    {
        $this->reference = $reference;
    }

    public function register(Container $container)
    {
        $container[$this->reference.'.language.strategy'] = null;
        $container[$this->reference.'.language.list'] = [];
        $container[$this->reference.'.language.default'] = null;

        $container[$this->reference] = function ($c) {
            $request = new HttpRequest();

            (new BaseUrlAutoResolver())->resolve($request);

            if (!empty($c[$this->reference.'.language.strategy'])) {
                $languages = $c[$this->reference.'.language.list'];
                $defaultLanguage = $c[$this->reference.'.language.default'];
                $languageResolver = null;
                switch ($c[$this->reference.'.language.strategy']) {
                    default:
                        throw new \Exception('Unknown language strategy "'.$strategy."'");
                    case 'subdirectory':
                        $languageResolver = new LanguageSubdirectoryResolver($languages, $defaultLanguage);
                        break;
                    case 'subdomain':
                        $languageResolver = new LanguageSubdomainResolver($languages, $defaultLanguage);
                        break;
                }

                $languageResolver->resolve($request);
            }

            return $urlParser->parse();
        };
    }
}
