```blade
@extends('adminlte::page')

@section('title', 'Domains')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1>Domains</h1>

            <small class="text-muted">
                Manage domains for {{ $website->name }}
            </small>
        </div>

        <a href="{{ route('admin.websites.domains.create', $website) }}"
           class="btn btn-primary">

            <i class="fas fa-plus"></i>
            Add Domain

        </a>
    </div>

@stop


@section('content')

    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif


    {{-- Info Message --}}
    @if(session('info'))

        <div class="alert alert-info alert-dismissible fade show">

            <i class="fas fa-info-circle mr-1"></i>

            {{ session('info') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif


    {{-- Error Messages --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fas fa-exclamation-circle mr-1"></i>

            <strong>Verification Error</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif


    {{-- Domains Table --}}
    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-globe mr-1"></i>

                All Domains

            </h3>

        </div>


        <div class="card-body">

            @if($domains->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Domain</th>

                                <th>Type</th>

                                <th>Status</th>

                                <th>Primary</th>

                                <th style="min-width: 280px;">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($domains as $domain)

                                <tr>

                                    {{-- ID --}}
                                    <td>
                                        {{ $domain->id }}
                                    </td>


                                    {{-- Domain --}}
                                    <td>

                                        <strong>
                                            {{ $domain->domain }}
                                        </strong>

                                        @if(
                                            $domain->status === 'verified' ||
                                            $domain->status === 'active'
                                        )

                                            <i class="fas fa-check-circle text-success ml-1"
                                               title="Verified"></i>

                                        @endif

                                    </td>


                                    {{-- Type --}}
                                    <td>

                                        @if($domain->type === 'custom')

                                            <span class="badge badge-primary">

                                                <i class="fas fa-globe mr-1"></i>

                                                Custom

                                            </span>

                                        @else

                                            <span class="badge badge-info">

                                                <i class="fas fa-link mr-1"></i>

                                                Subdomain

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @if($domain->status === 'pending')

                                            <span class="badge badge-warning">

                                                <i class="fas fa-clock mr-1"></i>

                                                Pending

                                            </span>

                                        @elseif($domain->status === 'verified')

                                            <span class="badge badge-success">

                                                <i class="fas fa-check-circle mr-1"></i>

                                                Verified

                                            </span>

                                        @elseif($domain->status === 'active')

                                            <span class="badge badge-success">

                                                <i class="fas fa-check-circle mr-1"></i>

                                                Active

                                            </span>

                                        @elseif($domain->status === 'disabled')

                                            <span class="badge badge-secondary">

                                                <i class="fas fa-ban mr-1"></i>

                                                Disabled

                                            </span>

                                        @else

                                            <span class="badge badge-secondary">

                                                {{ ucfirst($domain->status) }}

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Primary --}}
                                    <td>

                                        @if($domain->is_primary)

                                            <span class="badge badge-success">

                                                <i class="fas fa-star mr-1"></i>

                                                Primary

                                            </span>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td>

                                        <div class="d-flex align-items-center flex-wrap"
                                             style="gap: 5px;">


                                            {{-- Verify --}}
                                            @if($domain->status === 'pending')

                                                <form action="{{ route(
                                                    'admin.websites.domains.verify',
                                                    [$website, $domain]
                                                ) }}"
                                                      method="POST"
                                                      class="m-0">

                                                    @csrf

                                                    <button type="submit"
                                                            class="btn btn-sm btn-success">

                                                        <i class="fas fa-check-circle mr-1"></i>

                                                        Verify

                                                    </button>

                                                </form>

                                            @endif


                                            {{-- Edit --}}
                                            <a href="{{ route(
                                                'admin.websites.domains.edit',
                                                [$website, $domain]
                                            ) }}"
                                               class="btn btn-sm btn-warning">

                                                <i class="fas fa-edit mr-1"></i>

                                                Edit

                                            </a>


                                            {{-- Delete --}}
                                            <form action="{{ route(
                                                'admin.websites.domains.destroy',
                                                [$website, $domain]
                                            ) }}"
                                                  method="POST"
                                                  class="m-0">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm(
                                                            'Are you sure you want to delete this domain?'
                                                        )">

                                                    <i class="fas fa-trash mr-1"></i>

                                                    Delete

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                                {{-- DNS VERIFICATION INSTRUCTIONS --}}
                                @if(
                                    $domain->status === 'pending' &&
                                    !empty($domain->verification_token)
                                )

                                    <tr>

                                        <td colspan="6">

                                            <div class="card card-warning mb-0">

                                                <div class="card-header">

                                                    <h3 class="card-title">

                                                        <i class="fas fa-shield-alt mr-1"></i>

                                                        Verify {{ $domain->domain }}

                                                    </h3>

                                                </div>


                                                <div class="card-body">

                                                    <p class="mb-3">

                                                        <strong>
                                                            Add the following DNS TXT record
                                                        </strong>
                                                        to your domain provider.

                                                    </p>


                                                    <div class="row">


                                                        {{-- DNS TYPE --}}
                                                        <div class="col-md-3 mb-3">

                                                            <label class="text-muted">
                                                                DNS Type
                                                            </label>

                                                            <div class="form-control bg-light">

                                                                <strong>
                                                                    TXT
                                                                </strong>

                                                            </div>

                                                        </div>


                                                        {{-- DNS NAME --}}
                                                        <div class="col-md-4 mb-3">

                                                            <label class="text-muted">
                                                                Name / Host
                                                            </label>

                                                            <div class="input-group">

                                                                <input type="text"
                                                                       class="form-control"
                                                                       value="_newshub-verification"
                                                                       readonly>

                                                                <div class="input-group-append">

                                                                    <button type="button"
                                                                            class="btn btn-secondary"
                                                                            onclick="copyDnsValue(
                                                                                '_newshub-verification',
                                                                                this
                                                                            )">

                                                                        <i class="fas fa-copy"></i>

                                                                    </button>

                                                                </div>

                                                            </div>

                                                        </div>


                                                        {{-- DNS VALUE --}}
                                                        <div class="col-md-5 mb-3">

                                                            <label class="text-muted">
                                                                TXT Value
                                                            </label>

                                                            <div class="input-group">

                                                                <input type="text"
                                                                       class="form-control"
                                                                       value="{{ $domain->verification_token }}"
                                                                       readonly>

                                                                <div class="input-group-append">

                                                                    <button type="button"
                                                                            class="btn btn-secondary"
                                                                            onclick="copyDnsValue(
                                                                                '{{ $domain->verification_token }}',
                                                                                this
                                                                            )">

                                                                        <i class="fas fa-copy"></i>

                                                                    </button>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>


                                                    {{-- FULL DNS RECORD --}}
                                                    <div class="alert alert-light border">

                                                        <strong>
                                                            Full DNS Record:
                                                        </strong>

                                                        <code>
                                                            _newshub-verification.{{ $domain->domain }}
                                                        </code>

                                                        <br>

                                                        <strong>
                                                            TXT Value:
                                                        </strong>

                                                        <code>
                                                            {{ $domain->verification_token }}
                                                        </code>

                                                    </div>


                                                    {{-- INSTRUCTIONS --}}
                                                    <div class="alert alert-info mb-0">

                                                        <i class="fas fa-info-circle mr-1"></i>

                                                        After adding the TXT record, wait a few minutes
                                                        for DNS propagation and then click
                                                        <strong>Verify</strong>.

                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                @endif

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                <div class="mt-3">

                    {{ $domains->links() }}

                </div>

            @else

                {{-- Empty State --}}
                <div class="text-center py-5">

                    <i class="fas fa-globe fa-3x text-muted mb-3"></i>

                    <h4>
                        No Domain Found
                    </h4>

                    <p class="text-muted">

                        This website does not have any domain connected yet.

                    </p>

                    <a href="{{ route(
                        'admin.websites.domains.create',
                        $website
                    ) }}"
                       class="btn btn-primary">

                        <i class="fas fa-plus mr-1"></i>

                        Add First Domain

                    </a>

                </div>

            @endif

        </div>

    </div>

@stop


@section('js')

<script>

function copyDnsValue(value, button)
{
    navigator.clipboard.writeText(value).then(function () {

        const originalHtml = button.innerHTML;

        button.innerHTML =
            '<i class="fas fa-check"></i>';

        button.classList.remove('btn-secondary');

        button.classList.add('btn-success');

        setTimeout(function () {

            button.innerHTML = originalHtml;

            button.classList.remove('btn-success');

            button.classList.add('btn-secondary');

        }, 1500);

    });

}

</script>

@stop

