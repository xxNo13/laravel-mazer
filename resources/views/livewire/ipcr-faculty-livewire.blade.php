<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Individual Performance Commitment and Review</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">IPCR - Faculty</li>
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
        @foreach ($functs as $funct)
            <div class="hstack mb-3 gap-2">
                <h4>{{ $funct->funct }}</h4>
                @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                    ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                    <button type="button" class="ms-auto btn btn-outline-secondary" data-bs-toggle="modal"
                        data-bs-target="#ConfigureIPCROSTModal" title="Configure Output/Suboutput/Target">
                        Configure OST
                    </button>
                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" title="Save IPCR" wire:click="saveIPCR">
                        Save
                    </button>
                @endif
            </div>
            @foreach ($funct->outputs as $output)
                @if ($output->user_id == Auth::user()->id && $output->type == 'ipcr' && $output->duration_id == $duration->id && $output->user_type == 'faculty')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ $output->code }} {{ $number++ }} {{ $output->output }}</h4>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        @forelse ($output->suboutputs as $suboutput)
                            @if ($suboutput->user_id == Auth::user()->id &&
                                $suboutput->type == 'ipcr' &&
                                $suboutput->duration_id == $duration->id && $output->user_type == 'faculty')
                                <div class="card-body">
                                    <h6>{{ $suboutput->suboutput }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="accordion accordion-flush"
                                        id="{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                        <div class="d-sm-flex">
                                            @foreach ($suboutput->targets as $target)
                                                @if ($target->user_id == Auth::user()->id && $target->type == 'ipcr' && $target->duration_id == $duration->id && $output->user_type == 'faculty')
                                                    <div wire:ignore.self class="gap-2"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                        aria-expanded="true"
                                                        aria-controls="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                        role="button">
                                                        @if ($target->rating)
                                                            <span class="my-auto">
                                                                <i class="bi bi-check2"></i>
                                                            </span>
                                                        @endif
                                                        {{ $target->target }}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="card-body">
                                <div class="accordion accordion-flush"
                                    id="{{ str_replace(' ', '', $output->output) }}{{ $output->id }}">
                                    <div class="d-sm-flex">
                                        @foreach ($output->targets as $target)
                                            @if ($target->user_id == Auth::user()->id && $target->type == 'ipcr' && $target->duration_id == $duration->id && $output->user_type == 'faculty')
                                                <div wire:ignore.self class="accordion-button collapsed gap-2"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                    aria-expanded="true"
                                                    aria-controls="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                    role="button">
                                                    @if ($target->rating)
                                                        <span class="my-auto">
                                                            <i class="bi bi-check2"></i>
                                                        </span>
                                                    @endif
                                                    {{ $target->target }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                @endif
            @endforeach
        @endforeach
    </section>

    {{ $functs->links('components.pagination') }}
    <x-modals :ost="$ost" :selected="$selected" :users1="$users1" :users2="$users2" :type="$type" :duration="$duration" :userType="$userType" />
</div>
