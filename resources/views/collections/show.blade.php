@extends('layouts.app')

@section('title', $collection->name)

@section('content')
    <div class="container mt-3">
        <div class="row mb-4">
            <div class="col">
                <h1 class="display-4 mb-4">
                    {{ $collection->name }}
                </h1>
                @include('collections.partials.index.filter')
                @if($view === 'table')
                    @include('collections.partials.show.table')
                @else
                    @include('collections.partials.show.gallery')
                @endif
            </div>
        </div>
    </div>
@endsection
