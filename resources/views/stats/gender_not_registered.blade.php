
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Percentage of Females and Males Who Haven't Registered</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Gender</th>
                <th>Count</th>
                <th>Percentage (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $row)
            <tr>
                <td>{{ $row->gender }}</td>
                <td>{{ $row->count }}</td>
                <td>{{ $row->percentage }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection