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
                                @if($field->pages() & \AlexVanVliet\LAP\Pages::INDEX
                                    && $field->display() === \AlexVanVliet\LAP\Fields\Field::INLINE)
                                    <th scope="col" class="text-nowrap">
                                        @if ($field->sortKey())
                                            @php($sortQueryString = $sort['url']($field))
                                            <a href="{{ route('admin.index', [$resource])
                                                        .($sortQueryString ? "?sort=$sortQueryString" : '') }}">
                                                {{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}
                                                @php($sortOrder = $sort['order']($field))
                                                @if ($sortOrder)
                                                    <i class="fa fa-sort-{{ $sortOrder === 'asc' ? 'up' : 'down' }}"></i>
                                                    ({{ $sort['position']($field) }})
                                                @else
                                                    <i class="fa fa-sort"></i>
                                                @endif
                                            </a>
                                        @else
                                            {{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}
                                        @endif
                                    </th>
                                @endif
                                {{--@if($field->option('displayed', true))
                                    <th scope="col">
                                        @if ($sortingModule && $field->option('sort_key', false))
                                            <a href="{{ url($request->getRequest()->path()) }}?sort={{ urlencode($sortingModule->queryString($field)) }}">
                                                {{ $field->displayName() }}
                                                @if(!is_null($number = $sortingModule->number($field)))
                                                    ({{ $number + 1 }})
                                                @endif
                                            </a>
                                        @else
                                            {{ $field->displayName() }}
                                        @endif
                                    </th>
                                @endif--}}
                            @endforeach
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                @foreach($config['fields'] as $field)
                                    @if($field->pages() & \AlexVanVliet\LAP\Pages::INDEX
                                        && $field->display() === \AlexVanVliet\LAP\Fields\Field::INLINE)
                                        <td class="align-middle">
                                            @include($field->view('index'), [
                                                'type' => 'index',
                                                'field' => $field,
                                                'model' => $result,
                                            ])
                                        </td>
                                    @endif
                                @endforeach
                                <td class="align-middle">
                                    <a href="{{ route('admin.show', [$resource, $result]) }}" class="btn btn-light">
                                        Show
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($config['paginate'])
            {{ $results->links() }}
        @endif
    </div>
@endsection
