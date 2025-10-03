<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function genderNotRegistered()
    {
        // Compute per-gender totals and not-registered counts
        // Expose alias `count` to keep existing blade compatibility
        $results = DB::table('voters')
            ->select(
                'gender',
                DB::raw('COUNT(*) as total_gender'),
                DB::raw("SUM(CASE WHEN status = 'Not Registered' THEN 1 ELSE 0 END) as count")
            )
            ->groupBy('gender')
            ->get();

        foreach ($results as $row) {
            $row->percentage = $row->total_gender > 0 ? round(($row->count / $row->total_gender) * 100, 2) : 0;
        }

        return view('stats.gender_not_registered', ['results' => $results]);
    }

    public function candidatesNotRegistered()
    {
        $total = DB::table('candidates')->count();
        $notRegistered = DB::table('candidates')->where('status', 'Not Registered')->count();

        $percentage = $total > 0 ? round(($notRegistered / $total) * 100, 2) : 0;

        return view('stats.candidates_not_registered', [
            'total' => $total,
            'notRegistered' => $notRegistered,
            'percentage' => $percentage,
        ]);
    }

    public function nullVoidVotes()
    {
        // Aggregate by voters.constituency_ward (ward) to avoid relying on a missing votes.ward column
        $wards = DB::table('votes as v')
            ->join('voters as vt', 'vt.id', '=', 'v.voter_id')
            ->join(
                DB::raw('(SELECT vt2.constituency_ward as ward, COUNT(*) as total_per_ward FROM votes v2 JOIN voters vt2 ON vt2.id = v2.voter_id GROUP BY vt2.constituency_ward) as totals'),
                'totals.ward',
                '=',
                'vt.constituency_ward'
            )
            ->whereIn('v.vote_type', ['Null', 'Void'])
            ->groupBy('vt.constituency_ward', 'totals.total_per_ward')
            ->select(
                DB::raw('vt.constituency_ward as ward'),
                DB::raw('COUNT(*) as null_void_count'),
                DB::raw('ROUND(COUNT(*) * 100.0 / totals.total_per_ward, 2) as percentage')
            )
            ->get();

        return view('stats.null_void_votes', [
            'wards' => $wards,
        ]);
    }

    public function winningCandidates()
    {
        // Determine the top candidate per position by count of Valid votes
        $rows = DB::table('candidates as c')
            ->join('positions as p', 'p.id', '=', 'c.position_id')
            ->leftJoin('parties as party', 'party.id', '=', 'c.party_id')
            ->leftJoin('votes as v', function ($join) {
                $join->on('v.candidate_id', '=', 'c.id')
                     ->where('v.vote_type', '=', 'Valid');
            })
            ->groupBy('p.id', 'p.name', 'c.id', 'c.first_name', 'c.last_name', 'party.name')
            ->orderBy('p.id')
            ->orderByDesc(DB::raw('COUNT(v.id)'))
            ->select(
                'p.name as position',
                'c.first_name',
                'c.last_name',
                'party.name as party',
                DB::raw('COUNT(v.id) as valid_votes')
            )
            ->get();

        // Pick the first (highest) per position from ordered results
        $winners = $rows->groupBy('position')->map(function ($group) {
            return $group->first();
        })->values();

        return view('stats.winning_candidates', [
            'winners' => $winners,
        ]);
    }

    public function genderVoterCandidate()
    {
        // Candidate gender is not present in schema; report vote distribution by voter gender instead
        $results = DB::table('votes as v')
            ->join('voters as vt', 'vt.id', '=', 'v.voter_id')
            ->select('vt.gender', DB::raw('COUNT(*) as total_votes'))
            ->groupBy('vt.gender')
            ->get();

        $overall = $results->sum('total_votes');

        foreach ($results as $row) {
            $row->percentage = $overall > 0 ? round(($row->total_votes / $overall) * 100, 2) : 0;
        }

        return view('stats.gender_voter_candidate', [
            'results' => $results,
            'overall' => $overall,
        ]);
    }
}
