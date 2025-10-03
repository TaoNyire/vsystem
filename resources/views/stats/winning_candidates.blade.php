
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Winning Candidates per Position</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Position</th>
                <th>Candidate</th>
                <th>Party</th>
                <th>Valid Votes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($winners as $w)
            <tr>
                <td>{{ $w->position }}</td>
                <td>{{ $w->first_name }} {{ $w->last_name }}</td>
                <td>{{ $w->party ?? 'Independent/Unknown' }}</td>
                <td>{{ $w->valid_votes }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No data available</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection
