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
        @foreach($items as $key => $item)
            <tr>
                <td>{{ $items->firstItem() + $key }}</td>
                <td>{{ $item->name }}</td>
                <td><img src="{{ asset($item->file) }}" alt="{{ $item->name }}" class="img-thumbnail" style="height: 50px;width:100px; cursor: pointer;" data-toggle="modal" data-target="#imageModal" data-image="{{ asset($item->file) }}"></td>

                <td>
                    <input type="checkbox" class="is_active_switch" data-id="{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                </td>
                <td>{{ $item->description }}</td>
                <td>
                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $items->links() !!}
<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="img-fluid" alt="Image">
            </div>
        </div>
    </div>
</div>
@endsection

@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">
<style>
    .modal-dialog {
        max-width: 70% !important;
        margin: 1.75rem auto;
    }
</style>
@endsection

@section('customScript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
<script>
    $(document).ready(function() {
        $('.is_active_switch').bootstrapSwitch();

        // Handle switch click using Ajax call
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

        // Handle image click to show in modal
        $('img[data-toggle="modal"]').on('click', function() {
            var imageUrl = $(this).data('image');
            $('#modalImage').attr('src', imageUrl);
        });
    });
</script>
@endsection