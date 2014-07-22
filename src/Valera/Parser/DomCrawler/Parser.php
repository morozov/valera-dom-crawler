<?php

namespace Valera\Parser\DomCrawler;

use Symfony\Component\DomCrawler\Crawler;
use Valera\Parser\Result;
use Valera\Resource;

/**
 * Symfony DomCrawler based parser
 *
 * @link http://symfony.com/doc/current/components/dom_crawler.html
 */
interface Parser
{
    /**
     * Parses the contents and populates the result with parsed data
     *
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @param \Valera\Parser\Result $result
     * @param \Valera\Resource $resource
     */
    public function parse(Crawler $crawler, Result $result, Resource $resource);
}
