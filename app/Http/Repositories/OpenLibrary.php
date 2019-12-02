<?php

namespace App\Http\Repositories;

use GuzzleHttp\Client as GuzzleClient;

class OpenLibrary
{
    public static function find(String $search, String $domain = 'q')
    {
        $guzzle = new GuzzleClient();
        $response = $guzzle->get(sprintf('http://openlibrary.org/search.json?%s=%s', static::translateDomain($domain), urlencode($search)));
        $results = json_decode($response->getBody());

        return $results;
    }

    public static function translateDomain(String $domain)
    {
        switch ($domain) {
            case 'author':
                return 'author';
            case 'title':
                return 'title',
            default:
                return 'q';
        }
    }
}
