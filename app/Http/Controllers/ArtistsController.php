<?php

namespace App\Http\Controllers;

use App\Artist;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Sorting
        $sort = $request->input('sort', 'balances');

        // Artists
        $artists = $this->getArtists($sort);

        // Index View
        return view('artists.index', compact('artists', 'sort'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Artist $artist)
    {
        // View File
        $view = $request->has('view') ? 'artists.show.table' : 'artists.show';

        // Get Cards
        $cards = $artist->cards()->withCount('balances')
            ->orderBy('balances_count', 'desc')
            ->paginate(20);

        // Show View
        return view($view, compact('artist', 'cards', 'view'));
    }

    /**
     * Get Artists
     * 
     * @param  string  $sort
     * @return \App\Artist
     */
    private function getArtists($sort)
    {
        $artists = Artist::with('balances')->withCount('balances', 'cards');

        switch($sort)
        {
            case 'balance':
                $artists = $artists->orderBy('balances_count', 'desc')->get();
                break;
            case 'cards':
                $artists = $artists->orderBy('cards_count', 'desc')->get();
                break;
            case 'collectors':
                $artists = $artists->get()->sortByDesc('collectors_count');
                break;
            case 'collections':
                $artists = $artists->get()->sortByDesc('collections_count');
                break;
            default:
                $artists = $artists->orderBy('balances_count', 'desc')->get();
                break;
        }

        return $artists;
    }
}