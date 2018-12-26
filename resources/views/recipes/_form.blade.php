{{-- Form for creating or editing a recipe --}}
<form method="POST" action="{{ $action }}">
    @method($method)
    @csrf
    @if (count($errors) > 0)
        <div class="text-danger">
            {{ $errors }}
        </div>
    @endif
    <div class="form-group">
        <label for="name">Recipe Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', optional($recipe)->name) }}" aria-describedby="nameHelp" placeholder="Enter a name for this recipe">
        <small id="nameHelp" class="form-text text-muted">This is how the recipe will show up in lists and mealplans</small>
    </div>
    <div class="form-group">
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
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
