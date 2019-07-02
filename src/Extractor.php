<?php

namespace mk85\sitemap;

use Exception;
use mk85\sitemap\Exceptions\FileDoesNotExistException;
use mk85\sitemap\Exceptions\InvalidSitemapException;
use SimpleXMLElement;

/**
 * Class Extractor
 * @package mk85\sitemap
 */
class Extractor
{
    /**
     * @param string $sitemapPath
     * @throws FileDoesNotExistException
     * @throws InvalidSitemapException
     * @return string[]
     */
    public function execute(string $sitemapPath)
    {
        if (!is_file($sitemapPath)) {
            throw new FileDoesNotExistException();
        }

        $urls = [];
        $xmlData = @file_get_contents($sitemapPath);
        try {
            $sitemap = @new SimpleXMLElement($xmlData);

            foreach ($sitemap->url as $url) {
                $urls[] = strval($url->loc);
            }
        } catch (Exception $exception) {
            throw new InvalidSitemapException();
        }

        return $urls;
    }
}
