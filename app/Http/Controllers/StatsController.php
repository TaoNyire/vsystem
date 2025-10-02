<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function genderNotRegistered() {
        $results = DB::table('voters')
            ->select('gender', DB::raw('COUNT(*) as count'))
            ->where('status', 'Not Registered')
            ->groupBy('gender')
            ->get();

        $total = DB::table('voters')->count();

        foreach ($results as $row) {
            $row->percentage = $total > 0 ? round(($row->count / $total) * 100, 2) : 0;
        }

        return view('stats.gender_not_registered', ['results' => $results]);
    }


    public function candidatesNotRegistered()
{
    $total = \DB::table('candidates')->count();
    $notRegistered = \DB::table('candidates')->where('status', 'Not Registered')->count();

    $percentage = $total > 0 ? round(($notRegistered / $total) * 100, 2) : 0;

    return view('stats.candidates_not_registered', [
        'total' => $total,
        'notRegistered' => $notRegistered,
        'percentage' => $percentage,
    ]);
}

public function nullVoidVotes()
{
    // Adjust table/column names as needed
    $wards = \DB::table('votes')
        ->select('ward',
            \DB::raw('COUNT(*) as null_void_count'),
            \DB::raw('ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM votes WHERE votes.ward = v.ward), 2) as percentage')
        )
        ->from('votes as v')
        ->whereIn('vote_type', ['Null', 'Void'])
        ->groupBy('ward')
        ->havingRaw('percentage > 0')
        ->get();

    return view('stats.null_void_votes', [
        'wards' => $wards,
    ]);
}    
//  Implement other methods similarly, returning the correct views
}