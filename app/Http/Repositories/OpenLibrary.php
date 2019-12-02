<?php

namespace App\Http\Repositories;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class OpenLibrary
{
    private $hostname = 'https://openlibrary.org';
    private $cache_enabled = true;

    public function __construct()
    {
        $this->api = new GuzzleClient();
    }

    public function find(string $search, string $domain = 'q')
    {
        $results = $this->getApi(sprintf('search.json?%s=%s', $this->translateDomain($domain), urlencode($search)));
        $results = collect($results->docs)->filter(function ($item) {
            return property_exists($item, 'isbn');
        })->keyBy(function ($item) {
            return Arr::first($item->isbn);
        });

        return $this->sortBySimilar($results, $search);
    }

    public function getBook(string $isbn)
    {
        $results = collect($this->getApi(sprintf('api/books?bibkeys=isbn:%s&jscmd=data&format=json', $isbn)));

        return Arr::first($results);
    }

    public function withoutCache()
    {
        $this->cache_enabled = false;

        return $this;
    }

    private function getApi(string $endpoint)
    {
        if ($this->cache_enabled && cache()->has($endpoint)) {
            $results = cache()->get($endpoint);
            dump('from-cache');
        } else {
            $uri = sprintf('%s/%s', $this->hostname, $endpoint);
            $response = $this->api->get($uri);
            $results = json_decode($response->getBody());

            if ($this->cache_enabled) {
                cache()->put($endpoint, $results);
            }
        }

        return $results;
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
