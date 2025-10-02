
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Voting System Dashboard</h1>
    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="{{ route('stats.gender_not_registered') }}" class="btn btn-primary w-100">
                % Females & Males Not Registered
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('stats.winning_candidates') }}" class="btn btn-success w-100">
                Winning Candidates
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('stats.candidates_not_registered') }}" class="btn btn-warning w-100">
                % Candidates Not Registered
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('stats.null_void_votes') }}" class="btn btn-danger w-100">
                Null & Void Votes per Ward
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('stats.gender_voter_candidate') }}" class="btn btn-info w-100">
                % Female Voters for Female Candidates vs Male Voters for Male Candidates
            </a>
        </div>
    </div>
</div>
@endsection