@extends('lap::layout')

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header">{{ $title }}</h5>
            <div class="card-body">
                <form action="{{ route('admin.update', [$resource, $result]) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    @foreach($config['fields'] as $field)
                        @if($field->pages() & \AlexVanVliet\LAP\Pages::SHOW
                            && $field->display() === \AlexVanVliet\LAP\Fields\Field::INLINE)
                            @include($field->view('edit'), [
                                'type' => 'edit',
                                'field' => $field,
                                'model' => $result,
                            ])
                        @endif
                    @endforeach
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.show', [$resource, $result]) }}" class="btn btn-light">
                        Show
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
