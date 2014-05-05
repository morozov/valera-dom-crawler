<?php

namespace Valera\Parser\DomCrawler;

use Symfony\Component\DomCrawler\Crawler;
use Valera\Content;
use Valera\Parser\AdapterInterface;
use Valera\Parser\Result;

/**
 * Adapter of Symfony DomCrawler based parser
 */
class Adapter implements AdapterInterface
{
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    protected $crawler;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param mixed $parser
     *
     * @return boolean
     */
    public function supports($parser)
    {
        return $parser instanceof Parser;
    }

    /**
     * Wraps parser into standard interface
     *
     * @param \Valera\Parser\DomCrawler\Parser $parser
     *
     * @return callable
     */
    public function wrap($parser)
    {
        return function (Content $content, Result $result) use ($parser) {
            $this->crawler->clear();
            $this->crawler->addContent((string) $content);
            return $parser->parse($this->crawler, $result);
        };
    }
}