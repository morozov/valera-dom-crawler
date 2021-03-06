<?php

namespace Valera\Tests\Parser\DomCrawler;

use Valera\Content;
use Valera\Parser\DomCrawler\Adapter;
use Valera\Parser\Result;
use Valera\Resource;
use Valera\Source\DocumentSource;

class AdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Valera\Parser\DomCrawler\Adapter
     */
    private $adapter;

    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    private $crawler;

    protected function setUp()
    {
        $this->crawler = $this->getMockBuilder(
            'Symfony\\Component\\DomCrawler\\Crawler'
        )->setMethods(array('addContent'))->getMock();
        $this->adapter = new Adapter($this->crawler);
    }

    /** @test */
    public function supports()
    {
        $parser = $this->getParser();
        $this->assertTrue($this->adapter->supports($parser));
        $this->assertFalse($this->adapter->supports(null));
    }

    /** @test */
    public function wrap()
    {
        $parser = $this->getParser();
        $wrapped = $this->adapter->wrap($parser);
        $resource = new Resource('http://example.com');
        $content = new Content(
            'test-content',
            'application/octet-stream',
            new DocumentSource('test-type', $resource)
        );
        $result = new Result();
        
        $this->crawler->expects($this->once())
            ->method('addContent')
            ->with('test-content', 'application/octet-stream');

        $parser->expects($this->once())
            ->method('parse')
            ->with($this->crawler, $result, $resource);

        $wrapped($content, $result, $resource);
    }

    private function getParser()
    {
        return $this->getMock('Valera\\Parser\\DomCrawler\\Parser');
    }
}
