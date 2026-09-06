 @extends('adminlte::page')

@section('title', 'Themes')

@section('content_header')
    <h1>Theme Library</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">

        <a href="{{ route('themes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add Theme
        </a>

    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Preview</th>
                        <th>Theme Name</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Trial</th>
                        <th>Status</th>
                        <th width="230">Action</th>
                    </tr>

                </thead>


                <tbody>

                @forelse($themes as $theme)

                    <tr>

                        {{-- ID --}}
                        <td>
                            {{ $theme->id }}
                        </td>


                        {{-- Preview --}}
                        <td>

                            @if($theme->preview_image)

                                <img
                                    src="{{ asset('storage/' . $theme->preview_image) }}"
                                    alt="{{ $theme->name }}"
                                    width="80"
                                    height="50"
                                    style="object-fit: cover;"
                                    class="rounded"
                                >

                            @else

                                <span class="text-muted">
                                    No Preview
                                </span>

                            @endif

                        </td>


                        {{-- Name --}}
                        <td>

                            <strong>
                                {{ $theme->name }}
                            </strong>

                            @if($theme->description)

                                <br>

                                <small class="text-muted">
                                    {{ Str::limit($theme->description, 60) }}
                                </small>

                            @endif

                        </td>


                        {{-- Type --}}
                        <td>

                            @if($theme->type === 'premium')

                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-crown"></i>
                                    Premium
                                </span>

                            @else

                                <span class="badge bg-success">
                                    <i class="fas fa-gift"></i>
                                    Free
                                </span>

                            @endif

                        </td>


                        {{-- Price --}}
                        <td>

                            @if($theme->type === 'premium')

                                ₹{{ number_format($theme->price, 2) }}

                            @else

                                <span class="text-success">
                                    Free
                                </span>

                            @endif

                        </td>


                        {{-- Trial --}}
                        <td>

                            @if($theme->type === 'premium' && $theme->trial_days > 0)
                             {{ $theme->trial_days }} Days

                            @else

                                <span class="text-muted">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- Status --}}
                        <td>

                            @if($theme->status)

                                <span class="badge bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        {{-- Actions --}}
                        <td>

                            <a
                                href="{{ route('themes.edit', $theme->id) }}"
                                class="btn btn-warning btn-sm"
                            >
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>


                            <form
                                action="{{ route('themes.destroy', $theme->id) }}"
                                method="POST"
                                style="display:inline-block;"
                                onsubmit="return confirm('Are you sure you want to delete this theme?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                >
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center py-4"
                        >
                            <i class="fas fa-palette fa-2x text-muted"></i>

                            <br><br>

                            No themes found.

                            <br><br>

                            <a
                                href="{{ route('themes.create') }}"
                                class="btn btn-primary btn-sm"
                            >
                                Add Your First Theme
                            </a>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        <div class="mt-3">

            {{ $themes->links() }}

        </div>

    </div>

</div>

@stop