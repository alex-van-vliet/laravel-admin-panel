@foreach($panel->getResources() as $resource)
    <a class="dropdown-item" href="{{ route('admin.index', [$resource]) }}">
        {{ \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::plural($resource)) }}
    </a>
@endforeach
