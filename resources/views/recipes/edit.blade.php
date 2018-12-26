@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit recipe: {{ $recipe->name }}
                    <a href="{{ route('recipes.show', ['recipe' => $recipe->id]) }}" class="float-right"><i class="fas fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('recipes._form', ['action' => route('recipes.update', ['recipe' => $recipe->id]), 'method' => 'PUT' ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
