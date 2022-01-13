<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\RateMovie;
use Illuminate\Validation\Rules\Exists;

class Api extends Controller
{

    public function genre(Request $request)
    {
        $columns = ['Movie_ID', 'Title', 'Genre', 'Description'];
        $filter = [];
        if ($request->genre) {
            $filter[] = ['Genre', 'LIKE', '%"' . $request->genre . '"%'];
        }
        return $this->query($columns, $filter);
    }

    public function timeSlot(Request $request)
    {
        $columns = ['Movie_ID', 'Title', 'Theater_name', 'Start_time', 'End_time', 'Description', 'Theater_room_no'];
        $filter = [];
        if ($request->theater_name) {
            $filter[] = ['Theater_name', '=', $request->theater_name];
        }
        if ($request->time_start) {
            $filter[] = ['Start_time', '>=', $request->time_start];
        }
        if ($request->time_end) {
            $filter[] = ['End_time', '<=', $request->time_end];
        }
        return $this->query($columns, $filter);
    }

    public function specificMovieTheater(Request $request)
    {
        $columns = ['Movie_ID', 'Title', 'Theater_name', 'Start_time', 'End_time', 'Description', 'Theater_room_no'];
        $filter = [];
        if ($request->theater_name) {
            $filter[] = ['Theater_name', '=', $request->theater_name];
        }
        if ($request->d_date) {
            $filter[] = ['D_date', '=', $request->d_date];
        }
        return $this->query($columns, $filter);
    }

    public function searchPerformer(Request $request)
    {
        $columns = ['Movie_ID', 'Overall_rating', 'Title', 'Description'];
        $filter = [];
        if ($request->performer_name) {
            $filter[] = ['Performer', 'LIKE', '%"' . $request->performer_name . '"%'];
        }
        return $this->query($columns, $filter);
    }

    public function giveRating(Request $request)
    {
        $rateMovie = new RateMovie();
        $rateMovie->Movie_title = $request->movie_title;
        $rateMovie->Username = $request->username;
        $rateMovie->Rating = $request->rating;
        $rateMovie->R_description = $request->r_description;
        $rateMovie->save();
        return [
            "message" => "Successfully added review for "
                . strtolower($request->movie_title) . " by user: " . strtolower($request->username) . "",
            "success" => "true"
        ];
    }

    public function newMovies(Request $request)
    {
        $columns = ['Movie_ID', 'Overall_rating', 'Title', 'Description'];
        $filter = [];
        if ($request->r_date) {
            $filter[] = ['R_date', '<', $request->r_date];
        }
        return $this->query($columns, $filter);
    }

    public function addMovie(Request $request)
    {
        $movie = new Movie();
        $movie->Title = $request->title;
        $movie->Publish = $request->release;
        $movie->Length = $request->length;
        $movie->Description = $request->description;
        $movie->Mpaa_rating = $request->mpaa_rating;
        $movie->Genre = json_encode($request->genre);
        $movie->Director = $request->director;
        $movie->Performer = json_encode($request->performer);
        $movie->Language = $request->language;
        $movie->save();
        return [
            "message" => "Successfully added movie " . $request->title . " with Movie_ID " . $movie->id . "",
            "success" => "true"
        ];
    }

    private function query($columns, $filters)
    {
        $query = Movie::query()->select($columns);
        foreach ($filters as $filter) {
            $query = $query->where([$filter]);
        }
        $movies = $query->get();
        return $this->cleanData($movies, $columns);
    }

    private function cleanData($movies, $columns)
    {
        foreach ($movies as $movie) {
            foreach ($columns as $column) {
                switch ($column) {
                    case 'Genre':
                        $movie->Genre = implode(', ', json_decode($movie->Genre));
                        break;
                    case 'Theater_name':
                        $movie->Theater_name = strtolower($movie->Theater_name);
                        break;
                    case 'Start_time':
                    case 'End_time':
                        $movie->$column = $movie->$column
                            ? substr(date('c', strtotime($movie->$column)), 0, 19)
                            : '';
                        break;
                    default:
                        $movie->$column = $movie->$column ? $movie->$column = $movie->$column : '';
                }
            }
        }
        return ['date' => $movies];
    }
}
