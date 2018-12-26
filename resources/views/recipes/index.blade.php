@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Recipes</div>

                <div class="card-body">

                    <div class="card">
                        <ul class="list-group list-group-flush">
                            @foreach ($recipes as $recipe)
                                <a href="{{ route('recipes.show', ['recipe' => $recipe->id]) }}" class="list-group-item list-group-item-action">
                                    {{ $recipe->name }}
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="card-footer">
                    {{ $recipes->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
