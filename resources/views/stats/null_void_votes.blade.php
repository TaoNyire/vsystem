
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Null and Void Votes per Ward (More Than Zero Percent)</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Ward</th>
                <th>Null & Void Votes</th>
                <th>Percentage (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wards as $ward)
            <tr>
                <td>{{ $ward->ward }}</td>
                <td>{{ $ward->null_void_count }}</td>
                <td>{{ $ward->percentage }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection