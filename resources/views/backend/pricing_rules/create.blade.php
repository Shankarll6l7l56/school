@extends('backend.layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ isset($rule) ? route('pricing-rules.update', $rule->id) : route('pricing-rules.store') }}">
        @csrf
        @if(isset($rule))
        @method('PUT')
        @endif

        <div class="form-group">
            <label for="rule_type">Rule Type</label>
            <select name="rule_type" class="form-control" required>
                @foreach(['base_fare', 'minimum_fare', 'distance', 'time', 'vehicle_type', 'location', 'surge', 'booking_type', 'extra', 'discount', 'cancellation'] as $type)
                <option value="{{ $type }}" {{ (isset($rule) && $rule->rule_type == $type) ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name">Rule Name</label>
            <input type="text" name="name" class="form-control" value="{{ $rule->name ?? '' }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $rule->description ?? '' }}</textarea>
        </div>

        <div class="form-check">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ (isset($rule) && $rule->is_active) ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        <button class="btn btn-success mt-3">{{ isset($rule) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection