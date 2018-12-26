@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Play Recipe Roulette!
                    {{-- <a href="{{ route('recipes.index') }}" class="float-right"><i class="fas fa-times"></i></a> --}}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('roulette.play') }}">
                        @method('POST')
                        @csrf
                        @if (count($errors) > 0)
                            <div class="text-danger">
                                {{ $errors }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="quantity">Play for how many days?</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" aria-describedby="quantityHelp" placeholder="How many days to play for?">
                            <small id="quantityHelp" class="form-text text-muted">This is how many recipes in a row will be randomly selected.</small>
                        </div>
                        {{-- <div class="form-group">
                            <label for="recipe">Recipe</label>
                            <textarea rows="10" class="form-control" name="recipe" id="recipe" aria-describedby="recipeHelp" placeholder="Enter the recipe">{{ old('recipe', optional($recipe)->recipe) }}</textarea>
                            <small id="recipeHelp" class="form-text text-muted">Enter the recipe info. Include whatever data you want. This field MUST be JSON.</small>
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select class="form-control" id="tags" aria-describedby="tagsHelp" multiple name="tags[]">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ optional(optional($recipe)->tags)->contains($tag->id) ? 'selected' : '' }}>{{ $tag->tag }}</option>
                                @endforeach
                            </select>
                            <small id="tagsHelp" class="form-text text-muted">Tag the recipe however you would like.</small>
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
