@extends('lap::layout')

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header d-flex">
                <span class="flex-grow-1">{{ $title }}</span>
                <a href="{{ route('admin.index', [$resource]) }}" class="mr-2"><i class="fa fa-list"></i></a>
                <a href="{{ route('admin.create', [$resource]) }}" class="mr-2"><i class="fa fa-plus"></i></a>
                <a href="{{ route('admin.edit', [$resource, $result]) }}" class="mr-2"><i class="fa fa-pencil-alt"></i></a>
                <form action="{{ route('admin.destroy', [$resource, $result]) }}" method="POST" class="d-inline">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <form action="{{ route('admin.destroy', [$resource, $result]) }}" method="POST" class="d-inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <a type="submit" href="#" onclick="this.parentNode.submit(); return false;">
                            <i class="fa fa-trash-alt text-danger"></i>
                        </a>
                    </form>
                </form>
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
