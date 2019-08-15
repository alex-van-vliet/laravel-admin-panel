@php($relatedModel = get_class($model->{$field->name()}()->getRelated()))
@if($panel->getConfig($relatedModel)['pages'] & \AlexVanVliet\LAP\Pages::SHOW)
    <a href="{{ route('admin.show', [$panel->findResource($relatedModel), $model->{$field->name()}]) }}">{{ $model->{$field->name()} }}</a>
@else
    {{ $model->{$field->name()} }}
@endif
