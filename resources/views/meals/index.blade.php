@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Meals</div>

                <div class="card-body">

                    <div class="card">
                        <ul class="list-group list-group-flush">
                            @inject('carbon', 'Carbon\Carbon')
                            @forelse ($meals as $meal)
                                {{-- <a href="{{ route('meals.show', ['meal' => $meal->id]) }}" class="list-group-item list-group-item-action">
                                    {{ $meal->name }}
                                </a> --}}
                                <div class="list-group-item">
                                    <h5 class="mb-1">{{ $carbon->parse($meal->day)->format('l, m/d/Y') }}</h5>
                                    <ul class="float-right list-group list-group-flush">
                                        {{ $meal->name }}
                                    </ul>
                                </div>
                            @empty
                                <li class="list-group-item">You don't have any meals, yet!</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="card-footer">
                    {{ $meals->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
