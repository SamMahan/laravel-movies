<?php

namespace Samuelm\Moviedb\Objects;
use Samuelm\MovieDb\Objects\Movie;

/**
 * 
 * This is where I create an object type to represent api JSON I get back
 * @property int $page 
 * @property array<Movie> $results
 * @property int $totalPages;
 * @property int $totalResults;
 */
class MovieSearchResponse {

    public $page;
    public $results;
    public $totalPages;
    public $totalResults;

    public function __construct(
        int $page, 
        array $results,
        int $totalPages,
        int $totalResults
    ) {
        $this->page = $page;
        $this->results = $results;
        $this->totalPages = $totalPages;
        $this->totalResults = $totalResults;
    }
}