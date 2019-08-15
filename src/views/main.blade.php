@extends('lap::layout')

@section('content')
    <div class="container d-flex flex-items-center flex-column">
        <div class="card mb-2">
            <h5 class="card-header d-flex">
                <span class="flex-grow-1">Admin Panel</span>
            </h5>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover mb-0">
                    <tbody>
                        @foreach($panel->getResources() as $resource)
                            <tr>
                                <th scope="col"
                                    class="align-middle">
                                    {{ \Illuminate\Support\Str::ucfirst(Str::plural($resource)) }}
                                </th>
                                <td>
                                    <a href="{{ route('admin.index', [$resource]) }}" class="btn btn-primary">
                                        List
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
