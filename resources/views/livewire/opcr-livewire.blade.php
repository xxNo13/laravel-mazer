<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Office Performance Commitment and Review</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">OPCR</li>
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
                <h4>
                    {{ $funct->funct }}
                    @if ($percentage)
                        @switch($funct->funct)
                            @case('Core Function')
                                {{ $percentage->core }}%
                                @break
                            @case('Strategic Function')
                                {{ $percentage->strategic }}%
                                @break
                            @case('Support Function')
                                {{ $percentage->support }}%
                                @break
                        @endswitch
                    @endif
                </h4>
                @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                    ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                    <button type="button" class="ms-auto btn btn-outline-secondary" data-bs-toggle="modal"
                        data-bs-target="#AddOPCROSTModal" title="Add Output/Suboutput/Target">
                        Add OST
                    </button>
                    @if (!$percentage)
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#AddPercentageModal" title="Add Percentage">
                            Add Percentage
                        </button>
                    @else
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                            data-bs-target="#EditPercentageModal" title="Edit Percentage" wire:click="percent">
                            Edit Percentage
                        </button>
                    @endif
                    @if ($targ)
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                            data-bs-target="#SubmitISOModal" title="Save OPCR" wire:click="submit">
                            Submit
                        </button>
                    @endif
                @elseif (($approval && $approval->superior1_status == 1 && $approval->superior2_status == 1) && 
                (!$assess || ($assess->superior1_status == 2 || $assess->superior2_status == 2)) &&
                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                    <button type="button" class="ms-auto btn btn-outline-info" data-bs-toggle="modal"
                        data-bs-target="#AssessISOModal" title="Save OPCR" wire:click="submit">
                        Submit
                    </button>
                @elseif (($approval && $approval->superior1_status == 1 && $approval->superior2_status == 1) && ($assess && $assess->superior1_status == 1 && $assess->superior2_status == 1))
                    <a href="/print/{{ 'opcr' }}?userType=office" target="_blank" class="ms-auto btn icon btn-primary" title="Print IPCR">
                        <i class="bi bi-printer"></i>
                    </a>
                @endif
            </div>
            @if ($funct->subFuncts)
                @foreach ($funct->subFuncts as $subFunct)
                    @if ($subFunct->user_id == Auth::user()->id &&
                        $subFunct->type == 'opcr' &&
                        $subFunct->duration_id == $duration->id &&
                        $subFunct->user_type == $userType)
                        <div>
                            <h5>
                                @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditOPCROSTModal" wire:click="select('{{ 'sub_funct' }}', {{ $subFunct->id }})">Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'sub_funct' }}', {{ $subFunct->id }})">Delete</a>
                                    </div>
                                @endif
                                {{ $subFunct->sub_funct }}
                                @if ($percentage)
                                    @foreach ($percentage->supports as $support)
                                        @if ($support->name == $subFunct->sub_funct)
                                            {{ $support->percent }}%
                                        @endif
                                    @endforeach
                                @endif
                            </h5>
                            @foreach ($subFunct->outputs as $output)
                                @if ($output->user_id == Auth::user()->id &&
                                    $output->type == 'opcr' &&
                                    $output->duration_id == $duration->id &&
                                    $output->user_type == $userType)
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditOPCROSTModal" wire:click="select('{{ 'output' }}', {{ $output->id }})">Edit</a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'output' }}', {{ $output->id }})">Delete</a>
                                                    </div>
                                                @endif
                                                {{ $output->code }} {{ $number++ }}
                                                {{ $output->output }}
                                            </h4>
                                            <p class="text-subtitle text-muted"></p>
                                        </div>
                                        @forelse ($output->suboutputs as $suboutput)
                                            @if ($suboutput->user_id == Auth::user()->id &&
                                                $suboutput->type == 'opcr' &&
                                                $suboutput->duration_id == $duration->id &&
                                                $output->user_type == $userType)
                                                <div class="card-body">
                                                    <h6>
                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                        ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditOPCROSTModal" wire:click="select('{{ 'suboutput' }}', {{ $suboutput->id }})">Edit</a>
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
                                                                @if ($target->user_id == Auth::user()->id &&
                                                                    $target->type == 'opcr' &&
                                                                    $target->duration_id == $duration->id &&
                                                                    $output->user_type == $userType)
                                                                    <span class="my-auto">
                                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                        ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditOPCROSTModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Edit</a>
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

                                                        @foreach ($suboutput->targets as $target)
                                                            @if ($target->user_id == Auth::user()->id &&
                                                                $target->type == 'opcr' &&
                                                                $target->duration_id == $duration->id &&
                                                                $output->user_type == $userType)
                                                                <div wire:ignore.self
                                                                    id="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="flush-headingOne"
                                                                    data-bs-parent="#{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                                                    <div class="accordion-body table-responsive">
                                                                        <table class="table table-lg text-center">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td rowspan="2">Alloted Budget</td>
                                                                                    <td rowspan="2">Responsible Office/Person</td>
                                                                                    <td rowspan="2">Actual Accomplishment</td>
                                                                                    <td colspan="4">Rating</td>
                                                                                    <td rowspan="2">Remarks</td>
                                                                                    <td rowspan="2">Actions</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>E</td>
                                                                                    <td>Q</td>
                                                                                    <td>T</td>
                                                                                    <td>A</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if ($target->rating)
                                                                                    <tr>
                                                                                        <td>{{ $target->rating->alloted_budget }}</td>
                                                                                        <td>{{ $target->rating->responsible }}</td>
                                                                                        <td>{{ $target->rating->accomplishment }}</td>
                                                                                        <td>
                                                                                            @if ($target->rating->efficiency)
                                                                                                {{ $target->rating->efficiency }}
                                                                                            @else
                                                                                                NR
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            @if ($target->rating->quality)
                                                                                                {{ $target->rating->quality }}
                                                                                            @else
                                                                                                NR
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            @if ($target->rating->timeliness)
                                                                                                {{ $target->rating->timeliness }}
                                                                                            @else
                                                                                                NR
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>{{ $target->rating->average }}</td>
                                                                                        <td>{{ $target->rating->remarks }}</td>
                                                                                        <td>
                                                                                            @if ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d'))
                                                                                                <button type="button"
                                                                                                    class="btn icon btn-success"
                                                                                                    wire:click="editRating({{ $target->rating->id }})"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#EditRatingModal"
                                                                                                    title="Edit Rating">
                                                                                                    <i class="bi bi-pencil-square"></i>
                                                                                                </button>
                                                                                                <button type="button"
                                                                                                    class="btn icon btn-danger"
                                                                                                    wire:click="rating({{ 0 }}, {{ $target->rating->id }})"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#DeleteModal"
                                                                                                    title="Delete Rating">
                                                                                                    <i class="bi bi-trash"></i>
                                                                                                </button>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @else
                                                                                    <tr>
                                                                                        <td colspan="8"></td>
                                                                                        <td>
                                                                                            @if ($approval &&
                                                                                                $approval->superior1_status == 1 &&
                                                                                                $approval->superior2_status == 1 &&
                                                                                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                                                <button type="button"
                                                                                                    class="btn icon btn-primary"
                                                                                                    wire:click="rating({{ $target->id }})"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#AddRatingModal"
                                                                                                    title="Add Rating">
                                                                                                    <i class="bi bi-plus"></i>
                                                                                                </button>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @empty
                                            <div class="card-body">
                                                <div class="accordion accordion-flush"
                                                    id="{{ str_replace(' ', '', $output->output) }}{{ $output->id }}">
                                                    <div class="d-sm-flex">
                                                        @foreach ($output->targets as $target)
                                                            @if ($target->user_id == Auth::user()->id &&
                                                                $target->type == 'opcr' &&
                                                                $target->duration_id == $duration->id &&
                                                                $output->user_type == $userType)
                                                                <span class="my-auto">
                                                                    @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                    ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                        <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditOPCROSTModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Edit</a>
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

                                                    @foreach ($output->targets as $target)
                                                        @if ($target->user_id == Auth::user()->id &&
                                                            $target->type == 'opcr' &&
                                                            $target->duration_id == $duration->id &&
                                                            $output->user_type == $userType)
                                                            <div wire:ignore.self
                                                                id="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="flush-headingOne"
                                                                data-bs-parent="#{{ str_replace(' ', '', $output->output) }}{{ $output->id }}">
                                                                <div class="accordion-body table-responsive">
                                                                    <table class="table table-lg text-center">
                                                                        <thead>
                                                                            <tr>
                                                                                <td rowspan="2">Alloted Budget</td>
                                                                                <td rowspan="2">Responsible Office/Person</td>
                                                                                <td rowspan="2">Actual Accomplishment</td>
                                                                                <td colspan="4">Rating</td>
                                                                                <td rowspan="2">Remarks</td>
                                                                                <td rowspan="2">Actions</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>E</td>
                                                                                <td>Q</td>
                                                                                <td>T</td>
                                                                                <td>A</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if ($target->rating)
                                                                                <tr>
                                                                                    <td>{{ $target->rating->alloted_budget }}</td>
                                                                                    <td>{{ $target->rating->responsible }}</td>
                                                                                    <td>{{ $target->rating->accomplishment }}</td>
                                                                                    <td>
                                                                                        @if ($target->rating->efficiency)
                                                                                            {{ $target->rating->efficiency }}
                                                                                        @else
                                                                                            NR
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>
                                                                                        @if ($target->rating->quality)
                                                                                            {{ $target->rating->quality }}
                                                                                        @else
                                                                                            NR
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>
                                                                                        @if ($target->rating->timeliness)
                                                                                            {{ $target->rating->timeliness }}
                                                                                        @else
                                                                                            NR
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>{{ $target->rating->average }}</td>
                                                                                    <td>{{ $target->rating->remarks }}</td>
                                                                                    <td>
                                                                                        @if ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d'))
                                                                                            <button type="button"
                                                                                                class="btn icon btn-success"
                                                                                                wire:click="editRating({{ $target->rating->id }})"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#EditRatingModal"
                                                                                                title="Edit Rating">
                                                                                                <i class="bi bi-pencil-square"></i>
                                                                                            </button>
                                                                                            <button type="button"
                                                                                                class="btn icon btn-danger"
                                                                                                wire:click="rating({{ 0 }}, {{ $target->rating->id }})"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#DeleteModal"
                                                                                                title="Delete Rating">
                                                                                                <i class="bi bi-trash"></i>
                                                                                            </button>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="8"></td>
                                                                                    <td>
                                                                                        @if ($approval &&
                                                                                            $approval->superior1_status == 1 &&
                                                                                            $approval->superior2_status == 1 &&
                                                                                            ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                                            <button type="button"
                                                                                                class="btn icon btn-primary"
                                                                                                wire:click="rating({{ $target->id }})"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#AddRatingModal"
                                                                                                title="Add Rating">
                                                                                                <i class="bi bi-plus"></i>
                                                                                            </button>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
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
                @if ($output->user_id == Auth::user()->id &&
                    $output->type == 'opcr' &&
                    $output->duration_id == $duration->id &&
                    $output->user_type == $userType)
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditOPCROSTModal" wire:click="select('{{ 'output' }}', {{ $output->id }})">Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteModal" wire:click="select('{{ 'output' }}', {{ $output->id }})">Delete</a>
                                    </div>
                                @endif
                                {{ $output->code }} {{ $number++ }} {{ $output->output }}
                            </h4>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        @forelse ($output->suboutputs as $suboutput)
                            @if ($suboutput->user_id == Auth::user()->id &&
                                $suboutput->type == 'opcr' &&
                                $suboutput->duration_id == $duration->id &&
                                $output->user_type == $userType)
                                <div class="card-body">
                                    <h6>
                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                        ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditOPCROSTModal" wire:click="select('{{ 'suboutput' }}', {{ $suboutput->id }})">Edit</a>
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
                                                @if ($target->user_id == Auth::user()->id &&
                                                    $target->type == 'opcr' &&
                                                    $target->duration_id == $duration->id &&
                                                    $output->user_type == $userType)
                                                    <span class="my-auto">
                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                        ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditOPCROSTModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Edit</a>
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

                                        @foreach ($suboutput->targets as $target)
                                            @if ($target->user_id == Auth::user()->id &&
                                                $target->type == 'opcr' &&
                                                $target->duration_id == $duration->id &&
                                                $output->user_type == $userType)
                                                <div wire:ignore.self
                                                    id="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingOne"
                                                    data-bs-parent="#{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                                    <div class="accordion-body table-responsive">
                                                        <table class="table table-lg text-center">
                                                            <thead>
                                                                <tr>
                                                                    <td rowspan="2">Alloted Budget</td>
                                                                    <td rowspan="2">Responsible Office/Person</td>
                                                                    <td rowspan="2">Actual Accomplishment</td>
                                                                    <td colspan="4">Rating</td>
                                                                    <td rowspan="2">Remarks</td>
                                                                    <td rowspan="2">Actions</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>E</td>
                                                                    <td>Q</td>
                                                                    <td>T</td>
                                                                    <td>A</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($target->rating)
                                                                    <tr>
                                                                        <td>{{ $target->rating->alloted_budget }}</td>
                                                                        <td>{{ $target->rating->responsible }}</td>
                                                                        <td>{{ $target->rating->accomplishment }}</td>
                                                                        <td>
                                                                            @if ($target->rating->efficiency)
                                                                                {{ $target->rating->efficiency }}
                                                                            @else
                                                                                NR
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($target->rating->quality)
                                                                                {{ $target->rating->quality }}
                                                                            @else
                                                                                NR
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($target->rating->timeliness)
                                                                                {{ $target->rating->timeliness }}
                                                                            @else
                                                                                NR
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $target->rating->average }}</td>
                                                                        <td>{{ $target->rating->remarks }}</td>
                                                                        <td>
                                                                            @if ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d'))
                                                                                <button type="button"
                                                                                    class="btn icon btn-success"
                                                                                    wire:click="editRating({{ $target->rating->id }})"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#EditRatingModal"
                                                                                    title="Edit Rating">
                                                                                    <i class="bi bi-pencil-square"></i>
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn icon btn-danger"
                                                                                    wire:click="rating({{ 0 }}, {{ $target->rating->id }})"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#DeleteModal"
                                                                                    title="Delete Rating">
                                                                                    <i class="bi bi-trash"></i>
                                                                                </button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td colspan="8"></td>
                                                                        <td>
                                                                            @if ($approval &&
                                                                                $approval->superior1_status == 1 &&
                                                                                $approval->superior2_status == 1 &&
                                                                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                                <button type="button"
                                                                                    class="btn icon btn-primary"
                                                                                    wire:click="rating({{ $target->id }})"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#AddRatingModal"
                                                                                    title="Add Rating">
                                                                                    <i class="bi bi-plus"></i>
                                                                                </button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="card-body">
                                <div class="accordion accordion-flush"
                                    id="{{ str_replace(' ', '', $output->output) }}{{ $output->id }}">
                                    <div class="d-sm-flex">
                                        @foreach ($output->targets as $target)
                                            @if ($target->user_id == Auth::user()->id &&
                                                $target->type == 'opcr' &&
                                                $target->duration_id == $duration->id &&
                                                $output->user_type == $userType)
                                                <span class="my-auto">
                                                    @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                    ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                        <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditOPCROSTModal" wire:click="select('{{ 'target' }}', {{ $target->id }})">Edit</a>
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

                                    @foreach ($output->targets as $target)
                                        @if ($target->user_id == Auth::user()->id &&
                                            $target->type == 'opcr' &&
                                            $target->duration_id == $duration->id &&
                                            $output->user_type == $userType)
                                            <div wire:ignore.self
                                                id="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                                                data-bs-parent="#{{ str_replace(' ', '', $output->output) }}{{ $output->id }}">
                                                <div class="accordion-body table-responsive">
                                                    <table class="table table-lg text-center">
                                                        <thead>
                                                            <tr>
                                                                <td rowspan="2">Alloted Budget</td>
                                                                <td rowspan="2">Responsible Office/Person</td>
                                                                <td rowspan="2">Actual Accomplishment</td>
                                                                <td colspan="4">Rating</td>
                                                                <td rowspan="2">Remarks</td>
                                                                <td rowspan="2">Actions</td>
                                                            </tr>
                                                            <tr>
                                                                <td>E</td>
                                                                <td>Q</td>
                                                                <td>T</td>
                                                                <td>A</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($target->rating)
                                                                <tr>
                                                                    <td>{{ $target->rating->alloted_budget }}</td>
                                                                    <td>{{ $target->rating->responsible }}</td>
                                                                    <td>{{ $target->rating->accomplishment }}</td>
                                                                    <td>
                                                                        @if ($target->rating->efficiency)
                                                                            {{ $target->rating->efficiency }}
                                                                        @else
                                                                            NR
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($target->rating->quality)
                                                                            {{ $target->rating->quality }}
                                                                        @else
                                                                            NR
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($target->rating->timeliness)
                                                                            {{ $target->rating->timeliness }}
                                                                        @else
                                                                            NR
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $target->rating->average }}</td>
                                                                    <td>{{ $target->rating->remarks }}</td>
                                                                    <td>
                                                                        @if ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d'))
                                                                            <button type="button"
                                                                                class="btn icon btn-success"
                                                                                wire:click="editRating({{ $target->rating->id }})"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#EditRatingModal"
                                                                                title="Edit Rating">
                                                                                <i class="bi bi-pencil-square"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn icon btn-danger"
                                                                                wire:click="rating({{ 0 }}, {{ $target->rating->id }})"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#DeleteModal"
                                                                                title="Delete Rating">
                                                                                <i class="bi bi-trash"></i>
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td colspan="8"></td>
                                                                    <td>
                                                                        @if ($approval &&
                                                                            $approval->superior1_status == 1 &&
                                                                            $approval->superior2_status == 1 &&
                                                                            ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                            <button type="button"
                                                                                class="btn icon btn-primary"
                                                                                wire:click="rating({{ $target->id }})"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#AddRatingModal"
                                                                                title="Add Rating">
                                                                                <i class="bi bi-plus"></i>
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
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

    {{ $functs->links('components.pagination') }}
    <x-modals :selected="$selected" :users1="$users1" :users2="$users2" :type="$type" :duration="$duration"
        :userType="$userType" :subFuncts="$subFuncts" :percentage="$percentage" />
</div>
