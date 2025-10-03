<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Voter;
use App\Models\Candidate;
use App\Models\Position;
use App\Models\Vote;

class VoteController extends Controller
{
    public function create(Request $request)
    {
        $positions = Position::orderBy('name')->get();
        $selectedPositionId = $request->query('position_id', optional($positions->first())->id);

        $candidatesQuery = Candidate::with(['party', 'position']);
        if ($selectedPositionId) {
            $candidatesQuery->where('position_id', $selectedPositionId);
        }
        $candidates = $candidatesQuery->orderBy('last_name')->orderBy('first_name')->get();

        return view('vote.create', [
            'positions' => $positions,
            'selectedPositionId' => $selectedPositionId,
            'candidates' => $candidates,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'voter_registration_number' => 'required|string',
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $voter = Voter::where('voter_registration_number', $validated['voter_registration_number'])->first();
        if (!$voter) {
            return back()->withErrors(['voter_registration_number' => 'Voter not found.'])->withInput();
        }
        if ($voter->status !== 'Registered') {
            return back()->withErrors(['voter_registration_number' => 'You are not registered to vote.'])->withInput();
        }

        $candidate = Candidate::with('position')->findOrFail($validated['candidate_id']);

        // Ensure the voter hasn't already voted for this position
        $alreadyVoted = Vote::where('voter_id', $voter->id)
            ->whereHas('candidate', function ($q) use ($candidate) {
                $q->where('position_id', $candidate->position_id);
            })
            ->exists();

        if ($alreadyVoted) {
            return back()->withErrors(['candidate_id' => 'You have already cast a vote for the position: ' . $candidate->position->name])->withInput();
        }

        Vote::create([
            'voter_id' => $voter->id,
            'candidate_id' => $candidate->id,
            'vote_type' => 'Valid',
            'ward' => $voter->constituency_ward,
        ]);

        return redirect()->route('vote.create', ['position_id' => $candidate->position_id])
            ->with('status', 'Vote cast successfully for ' . $candidate->first_name . ' ' . $candidate->last_name . ' (' . $candidate->position->name . ').');
    }

    // Multi-position voting UI
    public function multi(Request $request)
    {
        $positions = Position::with(['candidates' => function ($q) {
            $q->with('party')->orderBy('last_name')->orderBy('first_name');
        }])->orderBy('name')->get();

        return view('vote.multi', [
            'positions' => $positions,
        ]);
    }

    // Handle multi-position voting submission
    public function multiStore(Request $request)
    {
        $validated = $request->validate([
            'voter_registration_number' => 'required|string',
            'votes' => 'required|array',
            'votes.*' => 'nullable|integer|exists:candidates,id',
        ]);

        $voter = Voter::where('voter_registration_number', $validated['voter_registration_number'])->first();
        if (!$voter) {
            return back()->withErrors(['voter_registration_number' => 'Voter not found.'])->withInput();
        }
        if ($voter->status !== 'Registered') {
            return back()->withErrors(['voter_registration_number' => 'You are not registered to vote.'])->withInput();
        }

        $created = [];
        $skipped = [];

        foreach ($validated['votes'] as $positionId => $candidateId) {
            if (empty($candidateId)) {
                continue; // position not selected
            }

            $candidate = Candidate::with('position')->find($candidateId);
            if (!$candidate) {
                $skipped[] = "Invalid candidate selected for a position.";
                continue;
            }

            if ((int)$candidate->position_id !== (int)$positionId) {
                $skipped[] = 'Selected candidate does not belong to the chosen position: ' . ($candidate->position->name ?? '');
                continue;
            }

            $alreadyVoted = Vote::where('voter_id', $voter->id)
                ->whereHas('candidate', function ($q) use ($candidate) {
                    $q->where('position_id', $candidate->position_id);
                })
                ->exists();

            if ($alreadyVoted) {
                $skipped[] = 'Already voted for position: ' . ($candidate->position->name ?? '');
                continue;
            }

            Vote::create([
                'voter_id' => $voter->id,
                'candidate_id' => $candidate->id,
                'vote_type' => 'Valid',
                'ward' => $voter->constituency_ward,
            ]);

            $created[] = ($candidate->position->name ?? 'Position') . ': ' . $candidate->first_name . ' ' . $candidate->last_name;
        }

        $message = [];
        if (!empty($created)) {
            $message[] = 'Votes cast for ' . implode(', ', $created) . '.';
        }
        if (!empty($skipped)) {
            $message[] = 'Skipped: ' . implode('; ', $skipped) . '.';
        }

        return redirect()->route('vote.multi')->with('status', implode(' ', $message));
    }
}
