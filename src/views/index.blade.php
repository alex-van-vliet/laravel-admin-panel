@extends('lap::layout')

@php($indexModule = $request->getModule(\AlexVanVliet\LAP\Modules\Index::class))
@php($sortingModule = $request->getModule(\AlexVanVliet\LAP\Modules\Sorting::class))
@php($paginationModule = $request->getModule(\AlexVanVliet\LAP\Modules\Pagination::class))

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header">{{ $indexModule->getTitle() }}</h5>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            @foreach($request->getFields() as $field)
                                @if($field->option('displayed', true))
                                    <th scope="col">
                                        @if ($sortingModule && $field->option('sort_key', false))
                                            <a href="{{ url($request->getRequest()->path()) }}?sort={{ urlencode($sortingModule->queryString($field)) }}">
                                                {{ $field->displayName() }}
                                                @if(!is_null($number = $sortingModule->number($field)))
                                                    <i class="fa fa-sort-{{ ($sortingModule->order($field)) === 'asc' ? 'up' : 'down' }}"></i>
                                                    ({{ $number + 1 }})
                                                @else
                                                    <i class="fa fa-sort"></i>
                                                @endif
                                            </a>
                                        @else
                                            {{ $field->displayName() }}
                                        @endif
                                    </th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                @foreach($request->getFields() as $field)
                                    @if($field->option('displayed', true))
                                        <td>{{ $field->value($result) }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($paginationModule)
            @if ($sortingModule)
                {{ $results->appends(['sort' => $sortingModule->queryString()])->links() }}
            @else
                {{ $results->links() }}
            @endif
        @endif
    </div>
@endsection
