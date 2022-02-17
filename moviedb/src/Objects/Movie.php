<?php

namespace Samuelm\Moviedb\Objects;

/**
 * This is where I create an object type to represent api JSON I get back
 * @property int $adult 
 * @property string $backdropPath
 * @property array $genreIds
 * @property int $id
 * @property string $originalLanguge
 * @property string $originalTitle
 * @property string $overview
 * @property string $popularity
 * @property string $posterPath
 * @property string $releaseDate
 * @property string $title
 * @property string $video
 * @property string $voteAverage
 * @property string $voteCount
 * @property int $runtime
 * @property Array<Cast> $castArray
 */
class Movie {
    public $adult;
    public $backdropPath;
    public $genreIds;
    public $id;
    public $originalLanguage;
    public $originalTitle;
    public $overview;
    public $popularity;
    public $posterPath;
    public $releaseDate;
    public $title;
    public $video;
    public $voteAverage;
    public $voteCount;
    public $runtime;
    public $castArray;

    public function __construct($obj, $castArray = []) {
        $this->setValue('adult', 'adult', $obj);
        $this->setValue('backdrop_path', 'backdropPath', $obj);
        $this->setValue('genre_ids', 'genreIds', $obj);
        $this->setValue('id', 'id',  $obj);
        $this->setValue('original_language', 'originalLanguage', $obj);
        $this->setValue('original_title','originalTitle', $obj);
        $this->setValue('overview', 'overview', $obj);
        $this->setValue('popularity', 'popularity', $obj);
        $this->setValue('poster_path', 'posterPath', $obj);
        $this->setValue('release_date', 'releaseDate', $obj);
        $this->setValue('title', 'title', $obj);
        $this->setValue('video', 'video', $obj);
        $this->setValue('vote_average', 'voteAverage', $obj);
        $this->setValue('vote_count', 'voteCount', $obj);
        $this->setValue('runtime', 'runtime', $obj);
        $this->castArray = $castArray;
    }

    public function __set($key, $value) {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }

    public function setValue($key, $newKey, $obj) {
        if (property_exists($obj, $key)) $this->__set($newKey, $obj->$key);
    }
}