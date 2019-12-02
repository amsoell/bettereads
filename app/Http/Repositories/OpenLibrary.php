<?php

namespace App\Http\Repositories;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class OpenLibrary
{
    private $hostname = 'https://openlibrary.org';

    public function __construct()
    {
        $this->api = new GuzzleClient();
    }

    public function find(string $search, string $domain = 'q')
    {
        $response = $this->api->get(sprintf('%s/search.json?%s=%s', $this->hostname, $this->translateDomain($domain), urlencode($search)));
        $results = collect(json_decode($response->getBody())->docs)->filter(function ($item) {
            return property_exists($item, 'isbn');
        })->keyBy(function ($item) {
            return Arr::first($item->isbn);
        });

        return $this->sortBySimilar($results, $search);
    }

    public function getBook(string $isbn)
    {
        $response = $this->api->get(sprintf('%s/api/books?bibkeys=isbn:%s&jscmd=data&format=json', $this->hostname, $isbn));
        $results = json_decode($response->getBody());

        return Arr::first($results);
    }

    private function translateDomain(string $domain)
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

    private function sortBySimilar(Collection $results, string $target)
    {
        return $results->sort(function ($a, $b) use ($target) {
            return similar_text($b->title, $target) <=> similar_text($a->title, $target);
        });
    }
}
