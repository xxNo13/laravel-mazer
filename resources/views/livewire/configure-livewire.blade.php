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
                <div class="accordion accordion-flush card-header" id="officeAccordion">
                    <div class="accordion-item">
                        <div class="accordion-header hstack gap-2" id="flush-headingOne" wire:ignore.self>
                            <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#office"
                                wire:ignore.self aria-expanded="false" aria-controls="office" role="button">
                                <h4>Offices</h4>
                            </div>
                            <div class="ms-auto my-auto form-group position-relative has-icon-right">
                                <input type="text" class="form-control" placeholder="Search.."
                                    wire:model="searchoffice">
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
                        <div id="office" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
                            wire:ignore.self data-bs-parent="#officeAccordion">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-lg text-center">
                                        <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>BUILDING</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($offices as $office)
                                                <tr>
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
    </section>

    <x-modals />
</div>
