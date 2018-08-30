<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cards = Card::withCount('balances', 'collections')->orderBy('balances_count', 'desc')->paginate(100);

        return view('cards.index', compact('cards'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Card $card)
    {
        $token = $card->token;
        $last_match = $card->lastMatch();
        $likes = $card->likes()->count();
        $dislikes = $card->dislikes()->count();
        $balances = $card->balances()->paginate(20);
        $artists = $card->artists()->orderBy('primary', 'desc')->get();
        $collections = $card->collections()->orderBy('primary', 'desc')->get();
        $buy_orders = $card->token->getOrders()->orderBy('expire_index', 'asc')->get();
        $sell_orders = $card->token->giveOrders()->orderBy('expire_index', 'asc')->get();
        $order_matches_count = $card->token->backwardOrderMatches()->count() + $card->token->forwardOrderMatches()->count();

        return view('cards.show', compact('card', 'artists', 'balances', 'buy_orders', 'collections', 'dislikes', 'last_match', 'likes', 'order_matches_count', 'sell_orders', 'token'));
    }
}