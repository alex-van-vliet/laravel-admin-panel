@extends('lap::layout')

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header d-flex">
                <span class="flex-grow-1">{{ $title }}</span>
                @if($config['pages'] & \AlexVanVliet\LAP\Pages::INDEX)
                    <a href="{{ route('admin.index', [$resource]) }}" class="ml-2"><i class="fa fa-list"></i></a>
                @endif
            </h5>
            <div class="card-body">
                <form action="{{ route('admin.store', [$resource]) }}" method="POST">
                    {{ csrf_field() }}
                    @foreach($config['fields'] as $field)
                        @if($field->pages() & \AlexVanVliet\LAP\Pages::CREATE
                            && $field->display() === \AlexVanVliet\LAP\Fields\Field::INLINE)
                            @include($field->view('create'), [
                                'type' => 'create',
                                'field' => $field,
                            ])
                        @endif
                    @endforeach
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
