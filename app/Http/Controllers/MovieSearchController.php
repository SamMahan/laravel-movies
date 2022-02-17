<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieSearchRequest;
use Samuelm\Moviedb\QueryBuilder;
use App\Http\Resources\MovieSearchResource;
use Illuminate\Routing\Controller as BaseController;

class MovieSearchController extends BaseController
{
    public function search(MovieSearchRequest $request): MovieSearchResource
    {
        $request->validated();
        $query = $request->get('query');
        $apiKey = config("app.moviedb_api_key");
        $response = (new QueryBuilder($apiKey))->query($query)->get();
        return new MovieSearchResource($response);
    }
}
