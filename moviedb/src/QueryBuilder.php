<?php

namespace Samuelm\Moviedb;
use Samuelm\Moviedb\Exceptions\UnauthorizedException;
use Samuelm\Moviedb\Objects\Movie;

use Samuelm\Moviedb\Objects\Cast;
use Samuelm\Moviedb\Objects\MovieSearchResponse;
use GuzzleHttp\Client;

class QueryBuilder {
    protected $baseUri = 'https://api.themoviedb.org/3/';
    protected $query = '';
    protected $apiKey = '';
    protected $page = 1;
    protected $includeAdult = 'false';
    protected $language = 'en-US';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    
    /**
     * Sets the $query parameter of the request. Returns $this in order to allow for function
     * chaining if the query theoretically becomes more complex in the future. 
     * @param string $query
     * @return QueryBuilder
     */
    public function query(string $query = ''): QueryBuilder
    {
        $this->query = $query;
        return $this;
    }
    
    /**
     * returns a response from the movie api search endpoint
     *
     * @return array
     * @throws UnauthorizedException
     * @throws Exception
     */
    public function get(): MovieSearchResponse
    {        
        $client = new Client([
            'base_uri' => $this->baseUri."search/movie",
            'verify' => false
        ]);
        

        $response = json_decode(
            (
                (
                    $client->request(
                        'GET',
                        "?".http_build_query([
                            'api_key' => $this->apiKey,
                            'language' => $this->language,
                            'query' => $this->query,
                            'page' => $this->page,
                            'include_adult' => $this->includeAdult,
                        ]),
                        [
                            'verify' => false
                        ]
                    )
                )->getBody()
            )
        );
        
        if (array_key_exists('status_code', $response)) {
            if ($responseCode['status_code'] = 7) {
                throw new UnauthorizedException();
            }
            throw new \Exception(
                'Unhandled movieDb API error ' . 
                $responseCode['status_message'] . ' error-code:' . 
                $responseCode['status_code']
            );
        }
        
        $resultModelArray = [];

        foreach ($response->results as $result) {
            $castArray = $this->getCast($result->id);
            $details = $this->getDetails($result->id);
            $resultModelArray[] = new Movie($details, $castArray);
            break;
            //current requirements have me returning one movie, but I might want to retrieve
            //several at some time in the future. Maintaining the response as effectively
            //an array of one movie would make it easier to accommodate a multi-movie response in the future
        }

        return new MovieSearchResponse(
            $response->page,
            $resultModelArray,
            $response->total_pages,
            $response->total_results
        );
    }
    /**
     * made this function to keep the app simple but I understand that for efficiency's sake we'd want to 
     * break this down into an optional, separate query 
     *
     * @param [type] $movieId
     * @return void
     */
    protected function getCast($movieId) {
        $client = new Client([
            'base_uri' => $this->baseUri."movie/$movieId/credits",
            'verify' => false
        ]);
        

        $castResponse = json_decode(
            (
                (
                    $client->request(
                        'GET',
                        "?".http_build_query([
                            'api_key' => $this->apiKey,
                            'movie_id' => $movieId,
                    ]),
                        [
                            'verify' => false
                        ]
                    )
                )->getBody()
            )
        );
        $returnCastArray = [];
        foreach ($castResponse->cast as $rawCast) {
            $returnCastArray[]= new Cast($rawCast);
        }
        return $returnCastArray;
    }

    protected function getDetails($movieId) {
        $client = new Client([
            'base_uri' => $this->baseUri."movie/$movieId",
            'verify' => false
        ]);
        

        $response = json_decode(
            (
                (
                    $client->request(
                        'GET',
                        "?".http_build_query([
                            'api_key' => $this->apiKey,
                            'movie_id' => $movieId,
                    ]),
                        [
                            'verify' => false
                        ]
                    )
                )->getBody()
            )
        );
    

    return $response;
    }

}