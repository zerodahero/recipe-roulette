@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Add a recipe
                    <a href="{{ route('recipes.index') }}" class="float-right"><i class="fas fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('recipes._form', ['action' => route('recipes.store'), 'method' => 'POST', 'recipe' => null ])
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
