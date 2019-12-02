<?php

namespace App\Http\Repositories;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class OpenLibrary
{
    public static function find(string $search, string $domain = 'q')
    {
        $guzzle = new GuzzleClient();
        $response = $guzzle->get(sprintf('https://openlibrary.org/search.json?%s=%s', static::translateDomain($domain), urlencode($search)));
        $results = collect(json_decode($response->getBody())->docs)->filter(function ($item) {
            return property_exists($item, 'isbn');
        })->keyBy(function ($item) {
            return Arr::first($item->isbn);
        });

        return static::sortBySimilar($results, $search);
    }

    public static function getBook(string $isbn)
    {
        $guzzle = new GuzzleClient();
        $response = $guzzle->get(sprintf('https://openlibrary.org/api/books?bibkeys=isbn:%s&jscmd=data&format=json', $isbn));
        $results = json_decode($response->getBody());

        return Arr::first($results);
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

    public static function sortBySimilar(Collection $results, string $target)
    {
        return $results->sort(function ($a, $b) use ($target) {
            return similar_text($b->title, $target) <=> similar_text($a->title, $target);
        });
    }
}
