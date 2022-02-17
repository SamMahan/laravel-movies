<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieSearchResource extends JsonResource
{
    /**
     * I typically like to explicitly define every field that'll be in the 
     * resource in the toArray method, rather than just serializing the model
     * that it represents. This makes it easier to grok what exactly is being sent back to the user. 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resultsArray = [];
        foreach ($this->results as $movie) {
            $castArray = [];
            foreach ($movie->castArray as $cast) {
                $castArray[] = [
                    'name'=>$cast->name,
                    'character' => $cast->character
                ];
            }
            $resultsArray[] = [
                'adult' => $movie->adult,
                'backdropPath' => $movie->backdropPath,
                'genreIds' => $movie->genreIds,
                'id' => $movie->id,
                'originalLanguage' => $movie->originalLanguage, 
                'originalTitle' => $movie->originalTitle,
                'overview' => $movie->overview,
                'popularity' => $movie->popularity,
                'posterPath' => $movie->posterPath,
                'releaseDate' => $movie->releaseDate,
                'title' => $movie->title,
                'video' => $movie->video,
                'voteAverage' => $movie->voteAverage,
                'voteCount' => $movie->voteCount,
                'runtime' => $movie->runtime,
                'cast' => $castArray
            ];
        }
        return [
            'page' => $this->page,
            'totalPages' => $this->totalPages,
            'totalResults' => $this->totalResults,
            'results' => $resultsArray
        ];
    }
}
