
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cast Your Vote</h2>
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="GET" action="{{ route('vote.create') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label for="position_id" class="form-label">Position</label>
                <select name="position_id" id="position_id" class="form-select" onchange="this.form.submit()">
                    @foreach ($positions as $pos)
                        <option value="{{ $pos->id }}" {{ (int)$selectedPositionId === (int)$pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <form method="POST" action="{{ route('vote.store') }}">
        @csrf
        <div class="mb-3">
            <label for="voter_registration_number" class="form-label">Voter Registration Number</label>
            <input type="text" name="voter_registration_number" id="voter_registration_number" class="form-control" value="{{ old('voter_registration_number') }}" placeholder="e.g. BIS/23/SS/001" required>
            @error('voter_registration_number')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="candidate_id" class="form-label">Candidate</label>
            <select name="candidate_id" id="candidate_id" class="form-select" required>
                <option value="">-- Select Candidate --</option>
                @foreach ($candidates as $c)
                    <option value="{{ $c->id }}" {{ old('candidate_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->last_name }}, {{ $c->first_name }}
                        @if($c->party)
                            ({{ $c->party->abbreviation ?? $c->party->name }})
                        @endif
                    </option>
                @endforeach
            </select>
            @error('candidate_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cast Vote</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>
@endsection
