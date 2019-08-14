@extends('lap::layout')

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header">{{ $title }}</h5>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            @foreach($config['fields'] as $field)
                                @if($field->display() === \AlexVanVliet\LAP\Fields\Field::INLINE)
                                    <th scope="col">{{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}</th>
                                @endif
                                {{--@if($field->option('displayed', true))
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
                                @endif--}}
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                @foreach($config['fields'] as $field)
                                    @if($field->display() === \AlexVanVliet\LAP\Fields\Field::INLINE)
                                        <td>
                                            @include($field->view('index'), [
                                                'type' => 'index',
                                                'field' => $field,
                                                'model' => $result,
                                            ])
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{--@if ($paginationModule)
            @if ($sortingModule)
                {{ $results->appends(['sort' => $sortingModule->queryString()])->links() }}
            @else
                {{ $results->links() }}
            @endif
        @endif--}}
    </div>
@endsection
