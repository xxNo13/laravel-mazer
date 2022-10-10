<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tracking Tool for Monitoring Assignments</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">TTMA</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="toastify on  toastify-right toastify-bottom" aria-live="polite"
            style="background: #41bbdd; transform: translate(0px, 0px); bottom: 15px;">
            {{ session('message') }}
        </div>
    @endif

    <section class="section pt-3">
        <div class="card">
            <div class="card-header hstack">
                <h4 class="card-title my-auto">Your Assignemnt</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-lg text-center">
                        <thead>
                            <tr>
                                <th>TASK ID No.</th>
                                <th>SUBJECT</th>
                                <th>ACTION OFFICER</th>
                                <th>OUTPUT</th>
                                <th>DATE ASSIGNED</th>
                                <th>DATE ACCOMPLISHED</th>
                                <th>REMARKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (Auth::user()->ttmas as $ttma)
                                @if (!$ttma->remarks && $duration && $ttma->duration_id == $duration->id)
                                    <tr>
                                        <td>{{ sprintf('%03u', $ttma->id) }}</td>
                                        <td>{{ $ttma->subject }}</td>
                                        <td>{{ $ttma->user->name }}</td>
                                        <td>{{ $ttma->output }}</td>
                                        <td>{{ date('M d, Y', strtotime($ttma->created_at)) }}</td>
                                        <td>
                                            @if ($ttma->remarks)
                                                {{ date('M d, Y', strtotime($ttma->updated_at)) }}
                                            @endif
                                        </td>
                                        <td>{{ $ttma->remarks }}</td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="8">No record available!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if (str_contains(strtolower(Auth::user()->account_types), 'head'))
            <hr>

            <div class="card">
                <div class="card-header hstack">
                    <h4 class="card-title my-auto">Subordinates</h4>
                    <div class="ms-auto my-auto form-group position-relative has-icon-right">
                        <input type="text" class="form-control" placeholder="Search.." wire:model="search">
                        <div class="form-control-icon">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-lg text-center">
                            <thead>
                                <tr>
                                    <th>TASK ID No.</th>
                                    <th>SUBJECT</th>
                                    <th>ACTION OFFICER</th>
                                    <th>OUTPUT</th>
                                    <th>DATE ASSIGNED</th>
                                    <th>DATE ACCOMPLISHED</th>
                                    <th>REMARKS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ttmas as $ttma)
                                    @if ($duration && $ttma->duration_id == $duration->id)
                                        <tr>
                                            <td>{{ sprintf('%03u', $ttma->id) }}</td>
                                            <td>{{ $ttma->subject }}</td>
                                            <td>{{ $ttma->user->name }}</td>
                                            <td>{{ $ttma->output }}</td>
                                            <td>{{ date('M d, Y', strtotime($ttma->created_at)) }}</td>
                                            <td>
                                                @if ($ttma->remarks)
                                                    {{ date('M d, Y', strtotime($ttma->updated_at)) }}
                                                @endif
                                            </td>
                                            <td>{{ $ttma->remarks }}</td>
                                            <td>
                                                @if ((!$ttma->remarks && ($ttma->duration_id == $duration->id)) && ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                    <div class="hstack gap-2">
                                                        <button type="button" class="btn icon btn-info"
                                                            data-bs-toggle="modal" data-bs-target="#DoneModal"
                                                            wire:click="select({{ $ttma->id }})">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                        <button type="button" class="btn icon btn-success"
                                                            data-bs-toggle="modal" data-bs-target="#EditTTMAModal"
                                                            wire:click="select({{ $ttma->id }}, '{{ 'edit' }}')">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button type="button" class="btn icon btn-danger"
                                                            data-bs-toggle="modal" data-bs-target="#DeleteModal"
                                                            wire:click="select({{ $ttma->id }})">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @elseif($loop->last)
                                        <tr>
                                            <td colspan="8">No record available!</td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="8">No record available!</td>
                                    </tr>
                                @endforelse
                                @if ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d'))
                                    <tr>
                                        <td colspan="7"></td>
                                        <td>
                                            <button type="button" class="btn icon btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#AddTTMAModal">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </section>

    {{ $ttmas->links('components.pagination') }}
    <x-modals :users="$users" />
</div>
