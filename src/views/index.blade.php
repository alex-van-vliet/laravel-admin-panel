@extends('lap::layout')

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header">{{ $title }}</h5>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            @foreach($fields as $field)
                                @if($field->option('displayed', true))
                                    <th scope="col">
                                        {{ $field->displayName() }}
                                    </th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                @foreach($fields as $field)
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
        @if (isset($paginated) && $paginated)
            {{ $results->render() }}
        @endif
    </div>
@endsection
