<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Result::with('user')->orderby('date', 'desc')->get();
        $bookmarks = Bookmark::get();
        return view('results.index', compact(['results', 'bookmarks']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function api(Request $request)
    {
        $gameName = 'thirdlf';
        $tagLine = 'JP1';
        $region = 'asia';

        $getPuuid = Http::withHeaders([
            "X-Riot-Token" => env('API_KEY'),
        ])->get("https://{$region}.api.riotgames.com/riot/account/v1/accounts/by-riot-id/{$gameName}/{$tagLine}");

        $userData = json_decode($getPuuid->body(), true);
        $puuid = $userData['puuid'];

        $getMatchList = Http::withHeaders([
            "X-Riot-Token" => env('API_KEY'),
        ])->get("https://{$region}.api.riotgames.com/tft/match/v1/matches/by-puuid/{$puuid}/ids?start=0&count=20");

        $matchLists = json_decode($getMatchList->body(), true);;

        foreach ($matchLists as $matchId) {
            $getResult = Http::withHeaders([
                "X-Riot-Token" => env('API_KEY'),
            ])->get("https://{$region}.api.riotgames.com/tft/match/v1/matches/{$matchId}");

            $resultData = json_decode($getResult->body(), true);

            for ($i = 0; $i <= 7; $i++) {
                if ($resultData['metadata']['participants']["$i"] == $puuid){
                    $list = ["date"=>$resultData['info']['game_datetime'],
                             "gameType"=>$resultData['info']['tft_game_type'],
                             "gameMode" => $resultData['info']['tft_set_core_name'],
                             "placement" =>$resultData['info']['participants']["$i"]['placement'],
                             "level"=>$resultData['info']['participants']["$i"]['level'],
                             "totalDamage"=>$resultData['info']['participants']["$i"]['total_damage_to_players']];

                    $json = json_encode($list);

                    $id = auth()->id();

                    $exitResult = Result::where('user_id', $id)
                        ->where('data_json', $json)
                        ->first();

                    if (!$exitResult) {
                        Result::create([
                            'date' => $resultData['info']['game_datetime'] / 1000,
                            'user_id' => $id,
                            'data_json' => $json,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('results.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        //
    }
}
