<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Standard</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Standard - Staff</li>
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
            <div class="hstack mb-3">
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
                    @if (isset($targ->standard))
                        <button type="button" class="ms-auto btn btn-outline-info" data-bs-toggle="modal"
                            data-bs-target="#SubmitISOModal" title="Submit Standard" wire:click="submit">
                            Submit
                        </button>
                    @endif
                @elseif (($approval && ($approval->superior1_status == 1 && $approval->superior2_status == 1)))
                    <a href="/print/{{ 'standard' }}?userType=staff" target="_blank" class="ms-auto btn icon btn-primary" title="Print IPCR">
                        <i class="bi bi-printer"></i>
                    </a>
                @endif
            </div>
            @if ($funct->subFuncts)
                @foreach ($funct->subFuncts as $subFunct)
                    @if ($subFunct->user_id == Auth::user()->id &&
                        $subFunct->type == 'ipcr' &&
                        $subFunct->duration_id == $duration->id &&
                        $subFunct->user_type == 'staff')
                        <div>
                            <h5>
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
                                    $output->type == 'ipcr' &&
                                    $output->duration_id == $duration->id &&
                                    $output->user_type == 'staff')
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ $output->code }} {{ $output->output }}</h4>
                                            <p class="text-subtitle text-muted"></p>
                                        </div>
                                        @forelse ($output->suboutputs as $suboutput)
                                            @if ($suboutput->user_id == Auth::user()->id &&
                                                $suboutput->type == 'ipcr' &&
                                                $suboutput->duration_id == $duration->id &&
                                                $output->user_type == 'staff')
                                                <div class="card-body">
                                                    <h6>{{ $suboutput->suboutput }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="accordion accordion-flush"
                                                        id="{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                                        <div class="d-sm-flex">
                                                            @foreach ($suboutput->targets as $target)
                                                                @if ($target->user_id == Auth::user()->id &&
                                                                    $target->type == 'ipcr' &&
                                                                    $target->duration_id == $duration->id &&
                                                                    $output->user_type == 'staff')
                                                                    <div wire:ignore.self
                                                                        class="accordion-button collapsed gap-2"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                                        aria-expanded="true"
                                                                        aria-controls="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                                        role="button">
                                                                        @if ($target->standard)
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
                                                                $target->type == 'ipcr' &&
                                                                $target->duration_id == $duration->id &&
                                                                $output->user_type == 'staff')
                                                                <div wire:ignore.self
                                                                    id="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="flush-headingOne"
                                                                    data-bs-parent="#{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                                                    <div class="accordion-body table-responsive">
                                                                        <table class="table table-lg text-center">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td colspan="6">Rating</td>
                                                                                    <td rowspan="2">Actions</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="2">E</td>
                                                                                    <td colspan="2">Q</td>
                                                                                    <td colspan="2">T</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if ($target->standard)
                                                                                    <tr>
                                                                                        <td>5</td>
                                                                                        <td>{{ $target->standard->eff_5 }}
                                                                                        </td>
                                                                                        <td>5</td>
                                                                                        <td>{{ $target->standard->qua_5 }}
                                                                                        </td>
                                                                                        <td>5</td>
                                                                                        <td>{{ $target->standard->time_5 }}
                                                                                        </td>
                                                                                        <td rowspan="5">
                                                                                            @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                                                <button type="button"
                                                                                                    class="btn icon btn-success"
                                                                                                    wire:click="clicked('{{ 'edit' }}', {{ $target->standard->id }})"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#EditStandardModal"
                                                                                                    title="Edit Standard">
                                                                                                    <i
                                                                                                        class="bi bi-pencil-square"></i>
                                                                                                </button>
                                                                                                <button type="button"
                                                                                                    class="btn icon btn-danger"
                                                                                                    wire:click="clicked('{{ 'delete' }}', {{ $target->standard->id }})"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#DeleteModal"
                                                                                                    title="Delete Standard">
                                                                                                    <i
                                                                                                        class="bi bi-trash"></i>
                                                                                                </button>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>4</td>
                                                                                        <td>{{ $target->standard->eff_4 }}
                                                                                        </td>
                                                                                        <td>4</td>
                                                                                        <td>{{ $target->standard->qua_4 }}
                                                                                        </td>
                                                                                        <td>4</td>
                                                                                        <td>{{ $target->standard->time_4 }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>3</td>
                                                                                        <td>{{ $target->standard->eff_3 }}
                                                                                        </td>
                                                                                        <td>3</td>
                                                                                        <td>{{ $target->standard->qua_3 }}
                                                                                        </td>
                                                                                        <td>3</td>
                                                                                        <td>{{ $target->standard->time_3 }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>2</td>
                                                                                        <td>{{ $target->standard->eff_2 }}
                                                                                        </td>
                                                                                        <td>2</td>
                                                                                        <td>{{ $target->standard->qua_2 }}
                                                                                        </td>
                                                                                        <td>2</td>
                                                                                        <td>{{ $target->standard->time_2 }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>1</td>
                                                                                        <td>{{ $target->standard->eff_1 }}
                                                                                        </td>
                                                                                        <td>1</td>
                                                                                        <td>{{ $target->standard->qua_1 }}
                                                                                        </td>
                                                                                        <td>1</td>
                                                                                        <td>{{ $target->standard->time_1 }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @else
                                                                                    <tr>
                                                                                        <td colspan="6"></td>
                                                                                        <td>
                                                                                            @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                                                <button type="button"
                                                                                                    class="btn icon btn-primary"
                                                                                                    wire:click="clicked('{{ 'add' }}', {{ $target->id }})"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#AddStandardModal"
                                                                                                    title="Add Standard">
                                                                                                    <i
                                                                                                        class="bi bi-plus"></i>
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
                                                                $target->type == 'ipcr' &&
                                                                $target->duration_id == $duration->id &&
                                                                $output->user_type == 'staff')
                                                                <div wire:ignore.self
                                                                    class="accordion-button collapsed gap-2"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                                    aria-expanded="true"
                                                                    aria-controls="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                                    role="button">
                                                                    @if ($target->standard)
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
                                                            $target->type == 'ipcr' &&
                                                            $target->duration_id == $duration->id &&
                                                            $output->user_type == 'staff')
                                                            <div wire:ignore.self
                                                                id="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="flush-headingOne"
                                                                data-bs-parent="#{{ str_replace(' ', '', $output->output) }}{{ $output->id }}">
                                                                <div class="accordion-body table-responsive">
                                                                    <table class="table table-lg text-center">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="6">Rating</td>
                                                                                <td rowspan="2">Actions</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">E</td>
                                                                                <td colspan="2">Q</td>
                                                                                <td colspan="2">T</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if ($target->standard)
                                                                                <tr>
                                                                                    <td>5</td>
                                                                                    <td>{{ $target->standard->eff_5 }}
                                                                                    </td>
                                                                                    <td>5</td>
                                                                                    <td>{{ $target->standard->qua_5 }}
                                                                                    </td>
                                                                                    <td>5</td>
                                                                                    <td>{{ $target->standard->time_5 }}
                                                                                    </td>
                                                                                    <td rowspan="5">
                                                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                                            ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                                            <button type="button"
                                                                                                class="btn icon btn-success"
                                                                                                wire:click="clicked('{{ 'edit' }}', {{ $target->standard->id }})"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#EditStandardModal"
                                                                                                title="Edit Standard">
                                                                                                <i
                                                                                                    class="bi bi-pencil-square"></i>
                                                                                            </button>
                                                                                            <button type="button"
                                                                                                class="btn icon btn-danger"
                                                                                                wire:click="clicked('{{ 'delete' }}', {{ $target->standard->id }})"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#DeleteModal"
                                                                                                title="Delete Standard">
                                                                                                <i
                                                                                                    class="bi bi-trash"></i>
                                                                                            </button>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>4</td>
                                                                                    <td>{{ $target->standard->eff_4 }}
                                                                                    </td>
                                                                                    <td>4</td>
                                                                                    <td>{{ $target->standard->qua_4 }}
                                                                                    </td>
                                                                                    <td>4</td>
                                                                                    <td>{{ $target->standard->time_4 }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>3</td>
                                                                                    <td>{{ $target->standard->eff_3 }}
                                                                                    </td>
                                                                                    <td>3</td>
                                                                                    <td>{{ $target->standard->qua_3 }}
                                                                                    </td>
                                                                                    <td>3</td>
                                                                                    <td>{{ $target->standard->time_3 }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>2</td>
                                                                                    <td>{{ $target->standard->eff_2 }}
                                                                                    </td>
                                                                                    <td>2</td>
                                                                                    <td>{{ $target->standard->qua_2 }}
                                                                                    </td>
                                                                                    <td>2</td>
                                                                                    <td>{{ $target->standard->time_2 }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>1</td>
                                                                                    <td>{{ $target->standard->eff_1 }}
                                                                                    </td>
                                                                                    <td>1</td>
                                                                                    <td>{{ $target->standard->qua_1 }}
                                                                                    </td>
                                                                                    <td>1</td>
                                                                                    <td>{{ $target->standard->time_1 }}
                                                                                    </td>
                                                                                </tr>
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="6"></td>
                                                                                    <td>
                                                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                                            ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                                            <button type="button"
                                                                                                class="btn icon btn-primary"
                                                                                                wire:click="clicked('{{ 'add' }}', {{ $target->id }})"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#AddStandardModal"
                                                                                                title="Add Standard">
                                                                                                <i
                                                                                                    class="bi bi-plus"></i>
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
                    $output->type == 'ipcr' &&
                    $output->duration_id == $duration->id &&
                    $output->user_type == 'staff')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ $output->code }} {{ $output->output }}</h4>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        @forelse ($output->suboutputs as $suboutput)
                            @if ($suboutput->user_id == Auth::user()->id &&
                                $suboutput->type == 'ipcr' &&
                                $suboutput->duration_id == $duration->id &&
                                $output->user_type == 'staff')
                                <div class="card-body">
                                    <h6>{{ $suboutput->suboutput }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="accordion accordion-flush"
                                        id="{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                        <div class="d-sm-flex">
                                            @foreach ($suboutput->targets as $target)
                                                @if ($target->user_id == Auth::user()->id &&
                                                    $target->type == 'ipcr' &&
                                                    $target->duration_id == $duration->id &&
                                                    $output->user_type == 'staff')
                                                    <div wire:ignore.self class="accordion-button collapsed gap-2"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                        aria-expanded="true"
                                                        aria-controls="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                        role="button">
                                                        @if ($target->standard)
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
                                                $target->type == 'ipcr' &&
                                                $target->duration_id == $duration->id &&
                                                $output->user_type == 'staff')
                                                <div wire:ignore.self
                                                    id="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingOne"
                                                    data-bs-parent="#{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                                    <div class="accordion-body table-responsive">
                                                        <table class="table table-lg text-center">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="6">Rating</td>
                                                                    <td rowspan="2">Actions</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">E</td>
                                                                    <td colspan="2">Q</td>
                                                                    <td colspan="2">T</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($target->standard)
                                                                    <tr>
                                                                        <td>5</td>
                                                                        <td>{{ $target->standard->eff_5 }}</td>
                                                                        <td>5</td>
                                                                        <td>{{ $target->standard->qua_5 }}</td>
                                                                        <td>5</td>
                                                                        <td>{{ $target->standard->time_5 }}</td>
                                                                        <td rowspan="5">
                                                                            @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                                <button type="button"
                                                                                    class="btn icon btn-success"
                                                                                    wire:click="clicked('{{ 'edit' }}', {{ $target->standard->id }})"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#EditStandardModal"
                                                                                    title="Edit Standard">
                                                                                    <i class="bi bi-pencil-square"></i>
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn icon btn-danger"
                                                                                    wire:click="clicked('{{ 'delete' }}', {{ $target->standard->id }})"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#DeleteModal"
                                                                                    title="Delete Standard">
                                                                                    <i class="bi bi-trash"></i>
                                                                                </button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>{{ $target->standard->eff_4 }}</td>
                                                                        <td>4</td>
                                                                        <td>{{ $target->standard->qua_4 }}</td>
                                                                        <td>4</td>
                                                                        <td>{{ $target->standard->time_4 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>{{ $target->standard->eff_3 }}</td>
                                                                        <td>3</td>
                                                                        <td>{{ $target->standard->qua_3 }}</td>
                                                                        <td>3</td>
                                                                        <td>{{ $target->standard->time_3 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>{{ $target->standard->eff_2 }}</td>
                                                                        <td>2</td>
                                                                        <td>{{ $target->standard->qua_2 }}</td>
                                                                        <td>2</td>
                                                                        <td>{{ $target->standard->time_2 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>{{ $target->standard->eff_1 }}</td>
                                                                        <td>1</td>
                                                                        <td>{{ $target->standard->qua_1 }}</td>
                                                                        <td>1</td>
                                                                        <td>{{ $target->standard->time_1 }}</td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td colspan="6"></td>
                                                                        <td>
                                                                            @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                                ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                                <button type="button"
                                                                                    class="btn icon btn-primary"
                                                                                    wire:click="clicked('{{ 'add' }}', {{ $target->id }})"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#AddStandardModal"
                                                                                    title="Add Standard">
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
                                                $target->type == 'ipcr' &&
                                                $target->duration_id == $duration->id &&
                                                $output->user_type == 'staff')
                                                <div wire:ignore.self class="accordion-button collapsed gap-2"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                    aria-expanded="true"
                                                    aria-controls="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                    role="button">
                                                    @if ($target->standard)
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
                                            $target->type == 'ipcr' &&
                                            $target->duration_id == $duration->id &&
                                            $output->user_type == 'staff')
                                            <div wire:ignore.self
                                                id="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                                                data-bs-parent="#{{ str_replace(' ', '', $output->output) }}{{ $output->id }}">
                                                <div class="accordion-body table-responsive">
                                                    <table class="table table-lg text-center">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="6">Rating</td>
                                                                <td rowspan="2">Actions</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">E</td>
                                                                <td colspan="2">Q</td>
                                                                <td colspan="2">T</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($target->standard)
                                                                <tr>
                                                                    <td>5</td>
                                                                    <td>{{ $target->standard->eff_5 }}</td>
                                                                    <td>5</td>
                                                                    <td>{{ $target->standard->qua_5 }}</td>
                                                                    <td>5</td>
                                                                    <td>{{ $target->standard->time_5 }}</td>
                                                                    <td rowspan="5">
                                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                            ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                            <button type="button"
                                                                                class="btn icon btn-success"
                                                                                wire:click="clicked('{{ 'edit' }}', {{ $target->standard->id }})"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#EditStandardModal"
                                                                                title="Edit Standard">
                                                                                <i class="bi bi-pencil-square"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn icon btn-danger"
                                                                                wire:click="clicked('{{ 'delete' }}', {{ $target->standard->id }})"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#DeleteModal"
                                                                                title="Delete Standard">
                                                                                <i class="bi bi-trash"></i>
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>{{ $target->standard->eff_4 }}</td>
                                                                    <td>4</td>
                                                                    <td>{{ $target->standard->qua_4 }}</td>
                                                                    <td>4</td>
                                                                    <td>{{ $target->standard->time_4 }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>{{ $target->standard->eff_3 }}</td>
                                                                    <td>3</td>
                                                                    <td>{{ $target->standard->qua_3 }}</td>
                                                                    <td>3</td>
                                                                    <td>{{ $target->standard->time_3 }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>{{ $target->standard->eff_2 }}</td>
                                                                    <td>2</td>
                                                                    <td>{{ $target->standard->qua_2 }}</td>
                                                                    <td>2</td>
                                                                    <td>{{ $target->standard->time_2 }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>{{ $target->standard->eff_1 }}</td>
                                                                    <td>1</td>
                                                                    <td>{{ $target->standard->qua_1 }}</td>
                                                                    <td>1</td>
                                                                    <td>{{ $target->standard->time_1 }}</td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td colspan="6"></td>
                                                                    <td>
                                                                        @if ((!$approval || ($approval->superior1_status == 2 || $approval->superior2_status == 2)) &&
                                                                            ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d')))
                                                                            <button type="button"
                                                                                class="btn icon btn-primary"
                                                                                wire:click="clicked('{{ 'add' }}', {{ $target->id }})"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#AddStandardModal"
                                                                                title="Add Standard">
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
    <x-modals :users1="$users1" :users2="$users2" />
</div>
