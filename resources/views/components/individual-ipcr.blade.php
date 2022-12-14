<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $user->name }} - IPCR - {{ strtoupper($userType) }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-3 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        @if ($url == 'officemates')
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('officemates') }}">Subordinates</a></li>
                        @elseif ($url == 'for-approval')
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('for-approval') }}">For Approval</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
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
        @if ($url == 'for-approval')
            <div class="my-5">
                <div class="hstack text-center text-nowrap">
                    <hr class="w-100">
                    <span class="mx-3">
                        <i class="bi bi-check-circle-fill fs-1"></i>
                        <p>Assign of IPCR</p>
                    </span>
                    <hr class="w-100">
                    <span class="mx-3">
                        @if ($approval->superior1_status == 1)
                            <i class="bi bi-check-circle-fill fs-1"></i>
                        @else
                            <i class="bi bi-x-circle-fill fs-1"></i>
                        @endif
                        <p>Head/Leader/Superior 1</p>
                    </span>
                    <hr class="w-100">
                    <span class="mx-3">
                        @if ($approval->superior2_status == 1)
                            <i class="bi bi-check-circle-fill fs-1"></i>
                        @else
                            <i class="bi bi-x-circle-fill fs-1"></i>
                        @endif
                        <p>Head/Leader/Superior 2</p>
                    </span>
                    <hr class="w-100">
                </div>
            </div>
        @endif

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
            </div>
            @if ($funct->subFuncts)
                @foreach ($funct->subFuncts as $subFunct)
                    @if ($subFunct->user_id == $user_id &&
                        $subFunct->type == 'ipcr' &&
                        $subFunct->duration_id == $duration->id &&
                        $subFunct->user_type == $userType)
                        <div>
                            <h5>
                                {{ $subFunct->sub_funct }}
                                @foreach ($percentage->supports as $support)
                                    @if ($support->name == $subFunct->sub_funct)
                                        {{ $support->percent }}%
                                    @endif
                                @endforeach
                            </h5>
                            @foreach ($subFunct->outputs as $output)
                                @if ($output->user_id == $user_id &&
                                    $output->type == 'ipcr' &&
                                    $output->duration_id == $duration->id &&
                                    $output->user_type == $userType)
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                {{ $output->code }} {{ $number++ }}
                                                {{ $output->output }}
                                            </h4>
                                            <p class="text-subtitle text-muted"></p>
                                        </div>
                                        @forelse ($output->suboutputs as $suboutput)
                                            @if ($suboutput->user_id == $user_id &&
                                                $suboutput->type == 'ipcr' &&
                                                $suboutput->duration_id == $duration->id &&
                                                $output->user_type == $userType)
                                                <div class="card-body">
                                                    <h6>
                                                        {{ $suboutput->suboutput }}
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="accordion accordion-flush"
                                                        id="{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                                        <div class="d-sm-flex">
                                                            @foreach ($suboutput->targets as $target)
                                                                @if ($target->user_id == $user_id &&
                                                                    $target->type == 'ipcr' &&
                                                                    $target->duration_id == $duration->id &&
                                                                    $output->user_type == $userType)
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
                                                            @if ($target->user_id == $user_id &&
                                                                $target->type == 'ipcr' &&
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
                                                                                    <td rowspan="2">Actual
                                                                                        Accomplishment</td>
                                                                                    <td colspan="4">Rating</td>
                                                                                    <td rowspan="2">Remarks</td>
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
                                                                                        <td>{{ $target->rating->accomplishment }}
                                                                                        </td>
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
                                                                                        <td>{{ $target->rating->average }}
                                                                                        </td>
                                                                                        <td>{{ $target->rating->remarks }}
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
                                                            @if ($target->user_id == $user_id &&
                                                                $target->type == 'ipcr' &&
                                                                $target->duration_id == $duration->id &&
                                                                $output->user_type == $userType)
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
                                                        @if ($target->user_id == $user_id &&
                                                            $target->type == 'ipcr' &&
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
                                                                                <td rowspan="2">Actual
                                                                                    Accomplishment</td>
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
                                                                                    <td>{{ $target->rating->accomplishment }}
                                                                                    </td>
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
                                                                                    <td>{{ $target->rating->average }}
                                                                                    </td>
                                                                                    <td>{{ $target->rating->remarks }}
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
                @if ($output->user_id == $user_id &&
                    $output->type == 'ipcr' &&
                    $output->duration_id == $duration->id &&
                    $output->user_type == $userType)
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                {{ $output->code }} {{ $number++ }} {{ $output->output }}
                            </h4>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        @forelse ($output->suboutputs as $suboutput)
                            @if ($suboutput->user_id == $user_id &&
                                $suboutput->type == 'ipcr' &&
                                $suboutput->duration_id == $duration->id &&
                                $output->user_type == $userType)
                                <div class="card-body">
                                    <h6>
                                        {{ $suboutput->suboutput }}
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="accordion accordion-flush"
                                        id="{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                        <div class="d-sm-flex">
                                            @foreach ($suboutput->targets as $target)
                                                @if ($target->user_id == $user_id &&
                                                    $target->type == 'ipcr' &&
                                                    $target->duration_id == $duration->id &&
                                                    $output->user_type == $userType)
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
                                            @if ($target->user_id == $user_id &&
                                                $target->type == 'ipcr' &&
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
                                            @if ($target->user_id == $user_id &&
                                                $target->type == 'ipcr' &&
                                                $target->duration_id == $duration->id &&
                                                $output->user_type == $userType)
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
                                        @if ($target->user_id == $user_id &&
                                            $target->type == 'ipcr' &&
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
</div>
