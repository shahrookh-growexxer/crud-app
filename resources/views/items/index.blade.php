@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Items</h1>
    <a href="{{ route('items.create') }}" class="btn btn-primary">Add Item</a>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Is Active</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td><img src="{{ asset($item->file) }}" style="width: 10%;"></td>
                <td>
                    <input type="checkbox" class="is_active_switch" data-id="{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                </td>
                <td>{{ $item->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">
@endsection

@section('customScript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
<script>
    $(document).ready(function() {
        $('.is_active_switch').bootstrapSwitch();

        $('.is_active_switch').on('switchChange.bootstrapSwitch', function(event, state) {
            var itemId = $(this).data('id');
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{ url('items') }}/' + itemId + '/toggle-active',
                method: 'POST',
                data: {
                    _token: token
                },
                success: function(response) {
                    console.log('Item ' + itemId + ' is now ' + (response.is_active ? 'active' : 'inactive'));
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });
    });
</script>
@endsection