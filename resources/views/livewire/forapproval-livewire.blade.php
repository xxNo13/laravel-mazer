<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>List of Subordinates</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">For Approval</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="toastify on  toastify-right toastify-bottom" aria-live="polite" style="background: #41bbdd; transform: translate(0px, 0px); bottom: 15px;">
            {{ session('message') }}
        </div>
    @endif

    <section class="section pt-3">
        <div class="card">
            <div class="card-header hstack">
                <h4 class="card-title my-auto"></h4>
                <div class="ms-auto my-auto form-group position-relative has-icon-right">
                    <input type="text" class="form-control" placeholder="Search.." wire:model="search">
                    <div class="form-control-icon">
                        <i class="bi bi-search"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <x-table-for-approval :approvals="$approvals" :duration="$duration" />
            </div>
        </div>
    </section>

    
    {{ $approvals->links('components.pagination') }}
    <x-modals />
</div>
