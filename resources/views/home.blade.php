@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <a class="list-group-item list-group-item-action" href="{{ route('recipes.create') }}">Add a recipe</a>
                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{{ route('recipes.index') }}">
                                Browse recipes
                                <span class="badge badge-primary badge-pill">{{ auth()->user()->recipes->count() }}</span>
                            </a>
                            <a class="list-group-item list-group-item-action list-group-item-primary" href="{{ route('roulette') }}">Play Roulette!</a>
                            <a class="list-group-item list-group-item-action" href="{{ route('meals.index') }}">Show meal plans</a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
