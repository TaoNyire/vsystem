
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Vote Distribution by Voter Gender</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Gender</th>
                <th>Total Votes</th>
                <th>Percentage (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $row)
            <tr>
                <td>{{ $row->gender }}</td>
                <td>{{ $row->total_votes }}</td>
                <td>{{ $row->percentage }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No data available</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection
