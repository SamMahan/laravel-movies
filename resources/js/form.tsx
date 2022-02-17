import React, { useState } from "react";
import {
    Formik,
    FormikHelpers,
    FormikProps,
    Form,
    Field,
    FieldProps,
} from "formik";
import * as ReactDOM from "react-dom";
import { MovieApiSearchUrl } from "./constants";
const axios = require("axios");

interface FormValues {
    query: string;
}
interface Cast {
    name: string;
    character: string;
}
interface Movie {
    adult: boolean;
    backdropPath: string;
    genreIds: Array<string>;
    id: number;
    originalLanguage: string;
    originalTitle: string;
    overview: string;
    popularity: string;
    posterPath: string;
    releaseDate: string;
    title: string;
    video: string;
    voteAverage: string;
    voteCount: string;
    cast: Array<Cast>;
}
const Search = () => {
    const [movie, setMovie] = useState(null);
    const [errorMessage, setErrorMessage] = useState("");
    let movieDisplay = <></>;
    if (movie) {
        let runTimeHours = Math.round(movie.runtime / 60);
        let runTimeMinutes = movie.runtime % 60;
        movieDisplay = (
            <>
                <p>Title: {movie.title} </p>
                <p>Overview: {movie.overview} </p>
                <p>Release Date: {movie.releaseDate} </p>
                <p>
                    Runtime: Hours: {runTimeHours}, Minutes: {runTimeMinutes}
                </p>
                <CastMembersComponent {...movie}></CastMembersComponent>
            </>
        );
    } else if (errorMessage) {
        movieDisplay = <p> {errorMessage}</p>;
    } else {
        movieDisplay = <p>We couldn't find any movies with that name...</p>;
    }
    return (
        <>
            <div className="col-6">
                <Formik
                    initialValues={{ query: "" }}
                    onSubmit={async (values: FormValues, actions) => {
                        actions.setSubmitting(true);

                        let response = await axios.get(MovieApiSearchUrl, {
                            params: { query: values.query },
                        });
                        if (response.status > 299) {
                            setErrorMessage(
                                "Looks like something's wrong on our end. Please come back later"
                            );
                            return;
                        }
                        setErrorMessage(null);
                        let movies = response.data;
                        if (
                            movies.data &&
                            movies.data.results &&
                            movies.data.results.length
                        ) {
                            setMovie(movies.data.results[0]);
                        } else {
                            setMovie(false);
                        }
                        actions.setSubmitting(false);
                    }}
                >
                    <Form>
                        <label htmlFor="searchTerm">Search...</label>

                        <Field
                            id="query"
                            name="query"
                            placeholder="Enter a search term..."
                        />

                        <button type="submit">Submit</button>
                    </Form>
                </Formik>
            </div>
            <div>{movieDisplay}</div>
        </>
    );
};

const CastMembersComponent = (movie: Movie) => {
    let castArr = [];
    let counter = 0;
    for (let index in movie.cast) {
        const cast = movie.cast[index];
        castArr.push(
            <li>
                Name: {cast.name} Character: {cast.character}
            </li>
        );
        counter++;
        if (counter > 10) break;
    }
    return (
        <>
            <p>Cast:</p>
            <ul>{castArr}</ul>
        </>
    );
};

if (document.getElementById("searchform")) {
    ReactDOM.render(<Search></Search>, document.getElementById("searchform"));
}
