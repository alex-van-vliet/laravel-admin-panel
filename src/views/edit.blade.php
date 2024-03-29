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
                @if($config['pages'] & \AlexVanVliet\LAP\Pages::SHOW)
                    <a href="{{ route('admin.show', [$resource, $result]) }}" class="ml-2"><i class="fa fa-eye"></i></a>
                @endif
                @if($config['pages'] & \AlexVanVliet\LAP\Pages::DELETE)
                    <a href="{{ route('admin.delete', [$resource, $result]) }}" class="ml-2"><i class="fa fa-trash-alt text-danger"></i></a>
                @endif
            </h5>
            <div class="card-body">
                <form action="{{ route('admin.update', [$resource, $result]) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    @foreach($config['fields'] as $field)
                        @if($field->pages() & \AlexVanVliet\LAP\Pages::EDIT
                            && $field->display() === \AlexVanVliet\LAP\Fields\Field::INLINE)
                            @include($field->view('edit'), [
                                'type' => 'edit',
                                'field' => $field,
                                'model' => $result,
                            ])
                        @endif
                    @endforeach
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
