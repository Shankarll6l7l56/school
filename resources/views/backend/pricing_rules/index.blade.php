@extends('backend.layouts.app')

@section('content')

<div class="container">
    <h2>Pricing Rules</h2> <a href="{{ route('pricing-rules.create') }}" class="btn btn-primary mb-3">Add New Rule</a>
  
    <table class="table table-responsive-sm table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Name</th>
                <th>Active</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pricingRules as $rule)
            <tr>
                <td>{{ $rule->id }}</td>
                <td>{{ ucfirst($rule->rule_type) }}</td>
                <td>{{ $rule->name }}</td>
                <td>{{ $rule->is_active ? 'Yes' : 'No' }}</td>
                <td class="text-end">
                    <a href="{{ route('pricing-rules.edit', $rule->id) }}" class="btn btn-sm btn-success">Edit</a>
                    <form action="{{ route('pricing-rules.destroy', $rule->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
 @endsection