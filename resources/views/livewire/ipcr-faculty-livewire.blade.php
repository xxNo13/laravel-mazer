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
            style="background: rgb(79, 190, 135); transform: translate(0px, 0px); bottom: 15px;">
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
                        data-bs-target="#AddIPCROSTModal" title="Add Output/Suboutput/Target">
                        Add OST
                    </button>
                    @if ($targ)
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" title="Save IPCR" wire:click="saveIPCR">
                            Save
                        </button>
                    @endif
                @elseif ($approval && $approval->superior1_status == 1 && $approval->superior2_status == 1)
                    <button type="button" class="ms-auto btn icon btn-primary" title="Print IPCR"
                        data-bs-toggle="modal" data-bs-target="#PrintModal">
                        <i class="bi bi-printer"></i>
                    </button>
                @endif
            </div>
            @if ($funct->subFuncts)
                @foreach ($funct->subFuncts as $subFunct)
                    @if ($subFunct->user_id == null &&
                        $subFunct->type == 'ipcr' &&
                        $subFunct->duration_id == $duration->id &&
                        $subFunct->user_type == $userType)
                        <div>
                            <h5>
                                @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditIPCROSTModal" wire:click="select('{{ 'sub_funct' }}', {{ $subFunct->id }})">Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'sub_funct' }}', {{ $subFunct->id }})">Delete</a>
                                    </div>
                                @endif
                                {{ $subFunct->sub_funct }}
                            </h5>
                            @foreach ($subFunct->outputs as $output)
                                @if ($output->user_id == null &&
                                    $output->type == 'ipcr' &&
                                    $output->duration_id == $duration->id &&
                                    $output->user_type == $userType)
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditIPCROSTModal" wire:click="select('{{ 'output' }}', {{ $output->id }})">Edit</a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'output' }}', {{ $output->id }})">Delete</a>
                                                    </div>
                                                @endif
                                                {{ $output->code }} {{ $number++ }}
                                                {{ $output->output }}
                                            </h4>
                                            <p class="text-subtitle text-muted"></p>
                                        </div>
                                        @forelse ($output->suboutputs as $suboutput)
                                            @if ($suboutput->user_id == null &&
                                                $suboutput->type == 'ipcr' &&
                                                $suboutput->duration_id == $duration->id &&
                                                $output->user_type == $userType)
                                                <div class="card-body">
                                                    <h6>
                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                        ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditIPCROSTModal" wire:click="select('{{ 'suboutput' }}', {{ $suboutput->id }})">Edit</a>
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'suboutput' }}', {{ $suboutput->id }})">Delete</a>
                                                            </div>
                                                        @endif
                                                        {{ $suboutput->suboutput }}
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="accordion accordion-flush"
                                                        id="{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                                        <div class="d-sm-flex">
                                                            @foreach ($suboutput->targets as $target)
                                                                @if ($target->user_id == null &&
                                                                    $target->type == 'ipcr' &&
                                                                    $target->duration_id == $duration->id &&
                                                                    $output->user_type == $userType)
                                                                    <span class="my-auto">
                                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                        ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditIPCROSTModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Edit</a>
                                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Delete</a>
                                                                            </div>
                                                                        @endif
                                                                    </span>
                                                                    <div wire:ignore.self
                                                                        class="accordion-button collapsed gap-2"
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
                                                            @if ($target->user_id == null &&
                                                                $target->type == 'ipcr' &&
                                                                $target->duration_id == $duration->id &&
                                                                $output->user_type == $userType)
                                                                <span class="my-auto">
                                                                    @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                    ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                        <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditIPCROSTModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Edit</a>
                                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Delete</a>
                                                                        </div>
                                                                    @endif
                                                                </span>
                                                                <div wire:ignore.self
                                                                    class="accordion-button collapsed gap-2"
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
                        </div>
                        <hr>
                    @endif
                @endforeach
            @endif
            @foreach ($funct->outputs as $output)
                @if ($output->user_id == null &&
                    $output->type == 'ipcr' &&
                    $output->duration_id == $duration->id &&
                    $output->user_type == $userType)
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditIPCROSTModal" wire:click="select('{{ 'output' }}', {{ $output->id }})">Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'output' }}', {{ $output->id }})">Delete</a>
                                    </div>
                                @endif
                                {{ $output->code }} {{ $number++ }} {{ $output->output }}
                            </h4>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        @forelse ($output->suboutputs as $suboutput)
                            @if ($suboutput->user_id == null &&
                                $suboutput->type == 'ipcr' &&
                                $suboutput->duration_id == $duration->id &&
                                $output->user_type == $userType)
                                <div class="card-body">
                                    <h6>
                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                        ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditIPCROSTModal" wire:click="select('{{ 'suboutput' }}', {{ $suboutput->id }})">Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'suboutput' }}', {{ $suboutput->id }})">Delete</a>
                                            </div>
                                        @endif
                                        {{ $suboutput->suboutput }}
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="accordion accordion-flush"
                                        id="{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                        <div class="d-sm-flex">
                                            @foreach ($suboutput->targets as $target)
                                                @if ($target->user_id == null &&
                                                    $target->type == 'ipcr' &&
                                                    $target->duration_id == $duration->id &&
                                                    $output->user_type == $userType)
                                                    <span class="my-auto">
                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                        ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditIPCROSTModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Edit</a>
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Delete</a>
                                                            </div>
                                                        @endif
                                                    </span>
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
                            @endif
                        @empty
                            <div class="card-body">
                                <div class="accordion accordion-flush"
                                    id="{{ str_replace(' ', '', $output->output) }}{{ $output->id }}">
                                    <div class="d-sm-flex">
                                        @foreach ($output->targets as $target)
                                            @if ($target->user_id == null &&
                                                $target->type == 'ipcr' &&
                                                $target->duration_id == $duration->id &&
                                                $output->user_type == $userType)
                                                <span class="my-auto">
                                                    @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                    ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                        <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditIPCROSTModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Edit</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Delete</a>
                                                        </div>
                                                    @endif
                                                </span>
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
    @if (isset($subFuncts))
        <x-modals :selected="$selected" :users1="$users1" :users2="$users2" :type="$type" :duration="$duration" :userType="$userType" :subFuncts="$subFuncts" :outputs="$outputs" :suboutputs="$suboutputs" :targets="$targets" :functs="$functs" />
    @endif
</div>
