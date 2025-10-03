
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cast Your Votes</h2>

    @if (session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('vote.multiStore') }}">
        @csrf

        <div class="mb-3">
            <label for="voter_registration_number" class="form-label">Voter Registration Number</label>
            <input type="text" name="voter_registration_number" id="voter_registration_number" class="form-control" value="{{ old('voter_registration_number') }}" placeholder="e.g. BIS/23/SS/001" required>
            @error('voter_registration_number')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        @foreach ($positions as $pos)
            <div class="card mb-3">
                <div class="card-header">
                    {{ $pos->name }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Choose Candidate</label>
                        <select name="votes[{{ $pos->id }}]" class="form-select">
                            <option value="">-- Do not vote for {{ $pos->name }} --</option>
                            @foreach ($pos->candidates as $c)
                                <option value="{{ $c->id }}" {{ (old('votes.' . $pos->id) == $c->id) ? 'selected' : '' }}>
                                    {{ $c->last_name }}, {{ $c->first_name }}
                                    @if($c->party)
                                        ({{ $c->party->abbreviation ?? $c->party->name }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($errors->has('votes'))
            <div class="text-danger">{{ $errors->first('votes') }}</div>
        @endif

        <button type="submit" class="btn btn-primary">Submit Votes</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>
@endsection
