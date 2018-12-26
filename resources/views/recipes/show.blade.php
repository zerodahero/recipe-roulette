@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $recipe->name }}
                    @foreach ($recipe->tags as $tag)
                        <span class="badge">{{ $tag->tag }}</span>
                    @endforeach
                    <a href="{{ route('recipes.edit', ['recipe' => $recipe->id]) }}" class="float-right"><i class="fas fa-edit"></i></a>
                </div>

                <div class="card-body">
                    {{ $recipe->recipe }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
