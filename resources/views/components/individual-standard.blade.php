<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $user->name }} - STANDARD - {{ strtoupper($userType) }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('for-approval') }}">For Approval</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

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
            </div>
            @if ($funct->subFuncts)
                @foreach ($funct->subFuncts as $subFunct)
                    @if ($subFunct->user_id == $user_id &&
                        $subFunct->type == $type &&
                        $subFunct->duration_id == $duration->id &&
                        $subFunct->user_type == $userType)
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
                                @if ($output->user_id == $user_id &&
                                    $output->type == $type &&
                                    $output->duration_id == $duration->id &&
                                    $output->user_type == $userType)
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ $output->code }} {{ $output->output }}</h4>
                                            <p class="text-subtitle text-muted"></p>
                                        </div>
                                        @forelse ($output->suboutputs as $suboutput)
                                            @if ($suboutput->user_id == $user_id &&
                                                $suboutput->type == $type &&
                                                $suboutput->duration_id == $duration->id &&
                                                $output->user_type == $userType)
                                                <div class="card-body">
                                                    <h6>{{ $suboutput->suboutput }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="accordion accordion-flush"
                                                        id="{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                                        <div class="d-sm-flex">
                                                            @foreach ($suboutput->targets as $target)
                                                                @if ($target->user_id == $user_id &&
                                                                    $target->type == $type &&
                                                                    $target->duration_id == $duration->id &&
                                                                    $output->user_type == $userType)
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
                                                            @if ($target->user_id == $user_id &&
                                                                $target->type == $type &&
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
                                                                                    <td colspan="6">Rating</td>
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
                                                                $target->type == $type &&
                                                                $target->duration_id == $duration->id &&
                                                                $output->user_type == $userType)
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
                                                        @if ($target->user_id == $user_id &&
                                                            $target->type == $type &&
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
                                                                                <td colspan="6">Rating</td>
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
                @if ($output->user_id == $user_id && $output->type == $type && $output->duration_id == $duration->id && $output->user_type == $userType)
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ $output->code }} {{ $output->output }}</h4>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        @forelse ($output->suboutputs as $suboutput)
                            @if ($suboutput->user_id == $user_id && $suboutput->type == $type && $suboutput->duration_id == $duration->id && $output->user_type == $userType)
                                <div class="card-body">
                                    <h6>{{ $suboutput->suboutput }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="accordion accordion-flush"
                                        id="{{ str_replace(' ', '', $suboutput->suboutput) }}{{ $suboutput->id }}">
                                        <div class="d-sm-flex">
                                            @foreach ($suboutput->targets as $target)
                                                @if ($target->user_id == $user_id && $target->type == $type && $target->duration_id == $duration->id && $output->user_type == $userType)
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
                                            @if ($target->user_id == $user_id && $target->type == $type && $target->duration_id == $duration->id && $output->user_type == $userType)
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
                                            @if ($target->user_id == $user_id && $target->type == $type && $target->duration_id == $duration->id && $output->user_type == $userType)
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
                                        @if ($target->user_id == $user_id && $target->type == $type && $target->duration_id == $duration->id && $output->user_type == $userType)
                                            <div wire:ignore.self
                                                id="{{ str_replace(' ', '', $target->target) }}{{ $target->id }}"
                                                class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                                                data-bs-parent="#{{ str_replace(' ', '', $output->output) }}{{ $output->id }}">
                                                <div class="accordion-body table-responsive">
                                                    <table class="table table-lg text-center">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="6">Rating</td>
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
