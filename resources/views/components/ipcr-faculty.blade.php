<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Faculty</h3>
            </div>
            <div class="col-12 col-md-6 order-md-3 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Faculty IPCR</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('message') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    @endif

    <section class="section pt-3">
        <div class="row">
            <div class="col-12 hstack">
                <button wire:loading.attr="disabled" class="ms-auto btn btn-outline-primary" wire:click="saveIPCR">
                    Save
                </button>
            </div>
        </div>
        @foreach ($functs as $funct)
            <div class="hstack mb-3">
                <h4>{{ $funct->funct }}</h4>
            </div>
            @foreach ($funct->outputs as $output)
                @if (!$output->user_id && $output->type == 'ipcr' && $output->duration_id == $duration->id && $output->user_type == $user_type)
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ $output->code }} {{ $number++ }} {{ $output->output }}</h4>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        @forelse ($output->suboutputs as $suboutput)
                            @if (!$suboutput->user_id && $suboutput->type == 'ipcr' && $suboutput->duration_id == $duration->id && $output->user_type == $user_type)
                                <div class="card-body">
                                    <h6>{{ $suboutput->suboutput }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-sm-flex gap-5">
                                        @foreach ($suboutput->targets as $target)
                                            @if (!$target->user_id && $target->type == 'ipcr' && $target->duration_id == $duration->id && $output->user_type == $user_type)
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="{{ $target->target }}{{ $target->id }}" value="{{ $target->id }}" wire:model="targets">
                                                    <label class="form-check-label" for="{{ $target->target }}{{ $target->id }}">{{ $target->target }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="card-body">
                                <div class="d-sm-flex gap-5">
                                    @foreach ($output->targets as $target)
                                        @if (!$target->user_id && $target->type == 'ipcr' && $target->duration_id == $duration->id && $output->user_type == $user_type)
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="{{ $target->target }}{{ $target->id }}" value="{{ $target->id }}" wire:model="targets">
                                                <label class="form-check-label" for="{{ $target->target }}{{ $target->id }}">{{ $target->target }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforelse
                    </div>
                @endif
            @endforeach
        @endforeach
    </section>
</div>