@extends('lap::layout')

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header d-flex">
                <span class="flex-grow-1">{{ $title }}</span>
                @if($config['pages'] & \AlexVanVliet\LAP\Pages::INDEX)
                    <a href="{{ route('admin.index', [$resource]) }}" class="ml-2"><i class="fa fa-list"></i></a>
                @endif
                @if($config['pages'] & \AlexVanVliet\LAP\Pages::CREATE)
                    <a href="{{ route('admin.create', [$resource]) }}" class="ml-2"><i class="fa fa-plus"></i></a>
                @endif
                @if($config['pages'] & \AlexVanVliet\LAP\Pages::EDIT)
                    <a href="{{ route('admin.edit', [$resource, $result]) }}" class="ml-2"><i class="fa fa-pencil-alt"></i></a>
                @endif
                @if($config['pages'] & \AlexVanVliet\LAP\Pages::DELETE)
                    <a href="{{ route('admin.delete', [$resource, $result]) }}" class="ml-2"><i class="fa fa-trash-alt text-danger"></i></a>
                @endif
            </h5>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
