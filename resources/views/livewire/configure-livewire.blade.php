<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Configuring available data</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Configure</li>
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
            <div class="accordion accordion-flush card-header" id="durationAccordion">
                <div class="accordion-item">
                    <div class="accordion-header hstack gap-2" id="flush-headingOne" wire:ignore.self>
                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#duration"
                            wire:ignore.self aria-expanded="false" aria-controls="duration" role="button">
                            <h4>Semester Duration</h4>
                        </div>
                    </div>
                    <div id="duration" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
                        wire:ignore.self data-bs-parent="#durationAccordion">
                        <div class="acordion-header mt-2 row">    
                            <div class="hstack justify-content-center gap-2 mt-2 col-12">
                                @if ($duration->end_date >= date('Y-m-d'))
                                @else
                                    <button type="button" class="ms-md-auto btn icon btn-primary" data-bs-toggle="modal"
                                        wire:click="select('{{ 'duration' }}')" data-bs-target="#AddDurationModal"
                                        title="Add Duration">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-lg text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($durations as $duration)
                                            <tr>
                                                <td>{{ $duration->id }}</td>
                                                <td>{{ date('M d, Y', strtotime($duration->start_date)) }}</td>
                                                <td>{{ date('M d, Y', strtotime($duration->end_date)) }}</td>
                                                <td>
                                                    @if (!($duration->start_date <= date('Y-m-d')))
                                                        <button type="button" class="btn icon btn-success"
                                                            wire:click="select('{{ 'duration' }}', {{ $duration->id }}, '{{ 'edit' }}')"
                                                            data-bs-toggle="modal" data-bs-target="#EditDurationModal">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button type="button" class="btn icon btn-danger"
                                                            wire:click="select('{{ 'duration' }}', {{ $duration->id }})"
                                                            data-bs-toggle="modal" data-bs-target="#DeleteModal">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @else
                                                        You can't Add, Edit or Delete the Semester's Duration since it already started/finished.
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No record available!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                {{ $durations->links('components.pagination') }}
            </div>
        </div>

        <div class="card">
            <div class="accordion accordion-flush card-header" id="officeAccordion">
                <div class="accordion-item">
                    <div class="accordion-header hstack gap-2" id="flush-headingOne" wire:ignore.self>
                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#office"
                            wire:ignore.self aria-expanded="false" aria-controls="office" role="button">
                            <h4>Offices</h4>
                        </div>
                    </div>
                    <div id="office" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
                        wire:ignore.self data-bs-parent="#officeAccordion">
                        <div class="acordion-header mt-2 row">
                            <div class="hstack justify-content-center justify-content-md-start col-12 col-md-6 gap-5 order-md-1 order-last">
                                <div class="my-auto form-group position-relative">
                                    <label for="ascOffice">Order By:</label>
                                    <select class="form-control" wire:model="ascOffice" id="ascOffice">
                                        <option value="asc">ASC</option>
                                        <option value="desc">DESC</option>
                                    </select>
                                </div>
                                <div class="my-auto form-group position-relative">
                                    <label for="sortOffice">Sort By:</label>
                                    <select class="form-control" wire:model="sortOffice" id="sortOffice">
                                        <option value="id">ID</option>
                                        <option value="office">Office Name</option>
                                        <option value="building">Building</option>
                                    </select>
                                </div>
                                <div class="my-auto form-group position-relative">
                                    <label for="pageOffice">Per Page:</label>
                                    <select class="form-control" wire:model="pageOffice" id="pageOffice">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="hstack justify-content-center gap-2 mt-2 col-12 col-md-6 order-md-1 order-last">
                                <div class="ms-md-auto my-auto form-group position-relative has-icon-right">
                                    <input type="text" class="form-control" placeholder="Search.." wire:model="searchoffice">
                                    <div class="form-control-icon">
                                        <i class="bi bi-search"></i>
                                    </div>
                                </div>
                                <button type="button" class="btn icon btn-primary" data-bs-toggle="modal"
                                    wire:click="select('{{ 'office' }}')" data-bs-target="#AddOfficeModal"
                                    title="Add Office">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-lg text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>OFFICE NAME</th>
                                            <th>BUILDING</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($offices as $office)
                                            <tr>
                                                <td>{{ $office->id }}</td>
                                                <td>{{ $office->office }}</td>
                                                <td>{{ $office->building }}</td>
                                                <td>
                                                    <button type="button" class="btn icon btn-success"
                                                        wire:click="select('{{ 'office' }}', {{ $office->id }}, '{{ 'edit' }}')"
                                                        data-bs-toggle="modal" data-bs-target="#EditOfficeModal">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button type="button" class="btn icon btn-danger"
                                                        wire:click="select('{{ 'office' }}', {{ $office->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#DeleteModal">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No record available!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                {{ $offices->links('components.pagination') }}
            </div>
        </div>

        <div class="card">
            <div class="accordion accordion-flush card-header" id="account_typeAccordion">
                <div class="accordion-item">
                    <div class="accordion-header hstack gap-2" id="flush-headingOne" wire:ignore.self>
                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#account_type"
                            wire:ignore.self aria-expanded="false" aria-controls="account_type" role="button">
                            <h4>Account Types</h4>
                        </div>
                    </div>
                    <div id="account_type" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
                        wire:ignore.self data-bs-parent="#account_typeAccordion">
                        <div class="acordion-header mt-2 row">
                            <div class="hstack justify-content-center  justify-content-md-start col-12 col-md-6 gap-5 order-md-1 order-last">
                                <div class="my-auto form-group position-relative">
                                    <label for="ascAccType">Order By:</label>
                                    <select class="form-control" wire:model="ascAccType" id="ascAccType">
                                        <option value="asc">ASC</option>
                                        <option value="desc">DESC</option>
                                    </select>
                                </div>
                                <div class="my-auto form-group position-relative">
                                    <label for="sortAccType">Sort By:</label>
                                    <select class="form-control" wire:model="sortAccType" id="sortAccType">
                                        <option value="id">ID</option>
                                        <option value="account_type">Account Type</option>
                                    </select>
                                </div>
                                <div class="my-auto form-group position-relative">
                                    <label for="pageAccType">Per Page:</label>
                                    <select class="form-control" wire:model="pageAccType" id="pageAccType">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="hstack justify-content-center gap-2 mt-2 col-12 col-md-6 order-md-1 order-last">
                                <div class="ms-md-auto my-auto form-group position-relative has-icon-right">
                                    <input type="text" class="form-control" placeholder="Search.." wire:model="searchacctype">
                                    <div class="form-control-icon">
                                        <i class="bi bi-search"></i>
                                    </div>
                                </div>
                                <button type="button" class="btn icon btn-primary" data-bs-toggle="modal"
                                    wire:click="select('{{ 'account_type' }}')" data-bs-target="#AddAccountTypeModal"
                                    title="Add Account Type">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-lg text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($account_types as $account_type)
                                            <tr>
                                                <td>{{ $account_type->id }}</td>
                                                <td>{{ $account_type->account_type }}</td>
                                                <td>
                                                    <button type="button" class="btn icon btn-success"
                                                        wire:click="select('{{ 'account_type' }}', {{ $account_type->id }}, '{{ 'edit' }}')"
                                                        data-bs-toggle="modal" data-bs-target="#EditAccountTypeModal">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button type="button" class="btn icon btn-danger"
                                                        wire:click="select('{{ 'account_type' }}', {{ $account_type->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#DeleteModal">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No record available!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                {{ $account_types->links('components.pagination') }}
            </div>
        </div>
    </section>

    <x-modals :startDate="$startDate" />
</div>
