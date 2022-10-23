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
                        <li class="breadcrumb-item active" aria-current="page">IPCR - Staff</li>
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
        <div class="hstack mb-3 gap-2">
            <h4>Core Function</h4>
            <button type="button" class="ms-auto btn btn-outline-secondary" data-bs-toggle="modal"
                data-bs-target="#ConfigureIPCROSTModal" title="Configure Output/Suboutput/Target">
                Configure OST
            </button>
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#SubmitISOModal"
                title="Save IPCR" wire:click="submit">
                Submit
            </button>
            <a href="/print/ipcr" type="button" class="btn icon btn-primary" title="Print IPCR">
                <i class="bi bi-printer"></i>
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">CF 1 Core Function 1</h4>
                <p class="text-subtitle text-muted"></p>
            </div>
            <div class="card-body">
                <h6>Suboutput 1</h6>
            </div>
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordion1">
                    <div class="d-sm-flex">
                        <div wire:ignore.self class="accordion-button collapsed gap-2" type="button"
                            data-bs-toggle="collapse" data-bs-target="#Suboutput" aria-expanded="true"
                            aria-controls="Suboutput" role="button">
                            <span class="my-auto">
                                <i class="bi bi-check2"></i>
                                Target 1
                            </span>
                        </div>
                    </div>


                    <div wire:ignore.self id="Suboutput" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingOne" data-bs-parent="#accordion1">
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
                                    <tr>
                                        <td>Accomplishment 1</td>
                                        <td>5</td>
                                        <td>5</td>
                                        <td>5</td>
                                        <td>5</td>
                                        <td>Done</td>
                                        <td>
                                            <button type="button" class="btn icon btn-success" data-bs-toggle="modal"
                                                data-bs-target="#EditRatingModal" title="Edit Rating">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn icon btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#DeleteModal" title="Delete Rating">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td>
                                            <button type="button" class="btn icon btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#AddRatingModal" title="Add Rating">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
