@extends('lap::layout')

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header d-flex">
                <span class="flex-grow-1">{{ $title }}</span>
                <a href="{{ route('admin.create', [$resource]) }}"><i class="fa fa-plus"></i></a>
            </h5>
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
                                            @php($sortQueryString = $sort['url']($sort, $field))
                                            <a href="{{ route('admin.index', [$resource])
                                                        .($sortQueryString ? "?sort=$sortQueryString" : '') }}">
                                                {{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}
                                                @php($sortOrder = $sort['order']($sort, $field))
                                                @if ($sortOrder)
                                                    <i class="fa fa-sort-{{ $sortOrder === 'asc' ? 'up' : 'down' }}"></i>
                                                    ({{ $sort['position']($sort, $field) }})
                                                @else
                                                    <i class="fa fa-sort"></i>
                                                @endif
                                            </a>
                                        @else
                                            {{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}
                                        @endif
                                    </th>
                                @endif
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
                                <td class="align-middle text-nowrap">
                                    <a href="{{ route('admin.show', [$resource, $result]) }}" class="btn btn-light btn-sm">
                                        Show
                                    </a>
                                    <a href="{{ route('admin.edit', [$resource, $result]) }}" class="btn btn-primary btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.destroy', [$resource, $result]) }}" method="POST" class="d-inline">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger btn-sm"
                                                type="submit">
                                            Delete
                                        </button>
                                    </form>
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
