
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Percentage of Candidates That Did Not Register</h2>
    <table class="table">
        <tr>
            <th>Total Candidates</th>
            <td>{{ $total }}</td>
        </tr>
        <tr>
            <th>Not Registered</th>
            <td>{{ $notRegistered }}</td>
        </tr>
        <tr>
            <th>Percentage (%)</th>
            <td>{{ $percentage }}</td>
        </tr>
    </table>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection