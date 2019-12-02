<?php

namespace App\Http\Repositories;

use GuzzleHttp\Client as GuzzleClient;

class OpenLibrary
{
    public static function find(string $search, string $domain = 'q')
    {
        $guzzle = new GuzzleClient();
        $response = $guzzle->get(sprintf('http://openlibrary.org/search.json?%s=%s', static::translateDomain($domain), urlencode($search)));
        $results = json_decode($response->getBody())->docs;

        return static::sortBySimilar($results, $search);
    }

    public static function translateDomain(string $domain)
    {
        switch ($domain) {
            case 'author':
                return 'author';
            case 'title':
                return 'title';
            default:
                return 'q';
        }
    }

    public static function sortBySimilar($results, $target)
    {
        usort($results, function ($a, $b) use ($target) {
            return similar_text($b->title, $target) <=> similar_text($a->title, $target);
        });

        return $results;
    }
}
