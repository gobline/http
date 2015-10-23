<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mendo\Http\Request\StringHttpRequest;
use Mendo\Http\Request\Resolver\BaseUrlResolver;
use Mendo\Http\Request\Resolver\LanguageSubdirectoryResolver;
use Mendo\Http\Request\Resolver\LanguageSubdomainResolver;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class HttpRequestTest extends PHPUnit_Framework_TestCase
{
    public function testStringHttpRequest()
    {
        $url = 'http://example.com:8080/foo/bar?hello=world&qux=corge';

        $request = new StringHttpRequest($url);

        $this->assertSame('http', $request->getProtocol());
        $this->assertSame('example.com', $request->getHost());
        $this->assertSame('world', $request->getQuery('hello'));
        $this->assertSame('corge', $request->getQuery('qux'));
        $this->assertSame('/foo/bar', $request->getPath());
        $this->assertSame(8080, $request->getPort());
        $this->assertSame('http://example.com:8080/foo/bar?hello=world&qux=corge', $request->getUrl(true));
    }
    public function testBaseUrlResolver()
    {
        $url = 'http://example.com/base-url/foo/bar?hello=world&qux=corge';

        $request = new StringHttpRequest($url);
        (new BaseUrlResolver('/base-url'))->resolve($request);

        $this->assertSame('world', $request->getQuery('hello'));
        $this->assertSame('corge', $request->getQuery('qux'));
        $this->assertSame('/foo/bar', $request->getPath());
        $this->assertSame('/base-url', $request->getBaseUrl());
        $this->assertSame('http://example.com/base-url/foo/bar?hello=world&qux=corge', $request->getUrl(true));
    }

    public function testLanguageSubdirectoryResolver()
    {
        $url = 'http://example.com/foo/bar';

        $request = new StringHttpRequest($url);
        (new LanguageSubdirectoryResolver(['fr', 'nl', 'en'], 'en'))->resolve($request);

        $this->assertSame('en', $request->getLanguage());
        $this->assertSame('/foo/bar', $request->getPath());
        $this->assertSame('/foo/bar', $request->getUrl());
        $this->assertSame($url, $request->getUrl(true));

        $request->setLanguage('fr');
        $this->assertSame('http://example.com/fr/foo/bar', $request->getUrl(true));

        $request->setPath('/hello/world');
        $this->assertSame('http://example.com/fr/hello/world', $request->getUrl(true));

        $request->setPort(8080);
        $this->assertSame('http://example.com:8080/fr/hello/world', $request->getUrl(true));
        $this->assertSame('/fr/hello/world', $request->getUrl(false));

        $url = 'http://example.com/fr/pomme/framboise';

        $request = new StringHttpRequest($url);
        (new LanguageSubdirectoryResolver(['fr', 'nl', 'en'], 'en'))->resolve($request);

        $this->assertSame('fr', $request->getLanguage());
        $this->assertSame('/pomme/framboise', $request->getPath());
        $this->assertSame('/fr/pomme/framboise', $request->getUrl());
        $this->assertSame($url, $request->getUrl(true));

        $url = 'http://example.com/fr/pomme/framboise';

        $request = new StringHttpRequest($url);
        (new LanguageSubdirectoryResolver(['fr', 'nl', 'en']))->resolve($request);

        $this->assertSame('fr', $request->getLanguage());
        $this->assertSame('/pomme/framboise', $request->getPath());
        $this->assertSame('/fr/pomme/framboise', $request->getUrl());
        $this->assertSame($url, $request->getUrl(true));

        $url = 'http://example.com/pomme/framboise';

        $request = new StringHttpRequest($url);
        (new LanguageSubdirectoryResolver(['fr', 'nl', 'en']))->resolve($request);

        $this->assertNull($request->getLanguage());
        $this->assertSame('/pomme/framboise', $request->getPath());
        $this->assertSame('/pomme/framboise', $request->getUrl());
        $this->assertSame($url, $request->getUrl(true));
    }

    public function testLanguageSubdomainResolver()
    {
        $url = 'http://example.com/foo/bar';

        $request = new StringHttpRequest($url);
        (new LanguageSubdomainResolver(['fr', 'nl', 'en'], 'en'))->resolve($request);

        $this->assertSame('en', $request->getLanguage());
        $this->assertSame('/foo/bar', $request->getPath());
        $this->assertSame('/foo/bar', $request->getUrl());
        $this->assertSame($url, $request->getUrl(true));

        $request->setLanguage('fr');
        $this->assertSame('http://fr.example.com/foo/bar', $request->getUrl(true));

        $request->setPath('/hello/world');
        $this->assertSame('http://fr.example.com/hello/world', $request->getUrl(true));

        $request->setPort(8080);
        $this->assertSame('http://fr.example.com:8080/hello/world', $request->getUrl(true));
        $this->assertSame('/hello/world', $request->getUrl(false));
    }

    public function testEmptyStringHttpRequest()
    {
        $request = new StringHttpRequest();

        $request->setHost('example.com');
        $request->setBaseUrl('/test');
        $request->setPath('/foo');

        $this->assertSame('//example.com/test/foo', $request->getUrl(true));
        $this->assertSame('/test/foo', $request->getUrl());
    }
}
