@extends('lap::layout')

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header">{{ $title }}</h5>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover mb-0">
                    <tbody>
                        @foreach($config['fields'] as $field)
                            @if($field->pages() & \AlexVanVliet\LAP\Pages::SHOW
                                && $field->display() === \AlexVanVliet\LAP\Fields\Field::INLINE)
                                <tr>
                                    <th scope="col">{{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}</th>
                                    <td>
                                        @include($field->view('show'), [
                                            'type' => 'show',
                                            'field' => $field,
                                            'model' => $result,
                                        ])
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <th scope="col" class="align-middle">Actions</th>
                            <td>
                                <a href="{{ route('admin.edit', [$resource, $result]) }}" class="btn btn-primary">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
