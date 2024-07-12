@extends('layouts.app')

@section('content')
<h1>Create Item</h1>
<form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        @if($errors->has('name'))
            <div class="text-danger">{{ $errors->first('name') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        @if($errors->has('description'))
            <div class="text-danger">{{ $errors->first('description') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for="file">File</label>
        <input type="file" name="file" id="file" class="form-control">
        @if($errors->has('file'))
            <div class="text-danger">{{ $errors->first('file') }}</div>
        @endif
    </div>
    <div class="form-check">
        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1">
        <label for="is_active" class="form-check-label">Is Active</label>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
