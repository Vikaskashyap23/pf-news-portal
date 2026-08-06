@extends('adminlte::page')

@section('title', 'News')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>News</h1>

        <a href="{{ route('news.create') }}" class="btn btn-primary">
            Add News
        </a>
    </div>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body">

    <br>
    
<form method="GET" action="{{ route('news.index') }}" class="row mb-3">

    <div class="col-md-3">
        <select name="website_id" class="form-control">
            <option value="">All Websites</option>

            @foreach($websites as $website)
                <option value="{{ $website->id }}">
                    {{ request('website_id') == $website->id ? 'selected' : '' }}
                    {{ $website->name }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-3">
        <select name="category_id" class="form-control">
            <option value="">All Categories</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ request('category_id') == $category->id ? 'selected' : '' }}
                    {{ $category->name }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-3">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Search News..."
               value="{{ request('search') }}">
    </div>

    <div class="col-md-3">
        <button type="submit" class="btn btn-primary">
            Search
        </button>

        <a href="{{ route('news.index') }}"
           class="btn btn-secondary ms-2">
            Reset
        </a>
    </div>

</form>

        <br>
        <br>
        <br>

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Website</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Breaking</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Slug</th>
                    <th>Created</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($news as $item)

                    <tr>

                        <td>{{ $item->id }}</td>

                        <td>{{ $item->website->name ?? '-' }}</td>

                        <td>{{ $item->category->name ?? '-' }}</td>

                        <td>

                            @if($item->featured_image)

                            <img src="{{ asset('storage/' . $item->featured_image) }}"
                               width="80"
                               height="50"
                               style="object-fit:cover; border-radius:5px;">
                             
                             @else
                                No Image 
                             @endif 

                        </td>

                        <td>{{ $item->title }}</td>

                        <td>
                            @if ($item->is_breaking)
                            
                            <span class="badge bg-danger"> YES </span>
                            @else
                             <span class="badge bg-secondary"> NO </span>

                             @endif
                        </td>

                        <td>

                            @if($item->is_featured)

                            <span class="badge bg-success">YES</span>

                            @else

                            <span class="badge bg-secondary"> NO </span>

                            @endif

                        </td>

                        <td>
                           <form action="{{ route('news.status', $item->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            @if($item->status)
                            <button type="submit" class="btn btn-success btn-sm">
                                Active
                            </button>
                            @else
                            <button type="submit" class="btn btn-danger btn-sm">
                                Inactive
                            </button>
                            @endif

                           </form>
                        </td>

                       <td>{{ $item->slug }} </td>
                        
                        <td>{{ $item->created_at->format('d M Y') }} </td>


                        <td>

                            <a href="{{ route('news.edit',$item->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('news.destroy',$item->id) }}"
                                  method="POST"
                                  style="display:inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this news?')">

                                    Delete

                                </button>

                            </form>

                        </td>


                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No News Found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-3">

            {{ $news->links() }}

        </div>

    </div>
</div>

@stop