@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Play Recipe Roulette!
                    <a href="{{ route('roulette') }}" class="float-right"><i class="fas fa-undo"></i></a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('roulette.store') }}">
                        @csrf
                        @method('POST')
                        @inject('carbon', 'Carbon\Carbon')
                        @foreach ($recipes as $recipe)
                            <div class="row my-2">
                                <div class="col">
                                    <input type="date" name="meals[{{ $loop->index }}][date]" class="form-control" value="{{ old('meals['.$loop->index.'][date]', $carbon->now()->addDays($loop->index)->format('Y-m-d')) }}" />
                                </div>
                                <div class="col">
                                    {{ $recipe->name }}
                                    <input type="hidden" name="meals[{{ $loop->index }}][recipe_id]" value="{{ $recipe->id }}" />
                                </div>
                            </div>
                        @endforeach
                        <hr class="my-4">
                        <button type="submit" class="btn btn-primary">Store Meal Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
