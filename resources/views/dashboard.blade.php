<x-app-layout>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
                <p class="text-subtitle text-muted">This is the main page.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>



    <section class="section">
        <div class="d-flex justify-content-center my-3">
            <h4 class="text-info fw-bold">MUST COMPLETE ALL FIRST WEEK AFTER MIDTERM EXAM TO START ALPHA TEST</h4>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Functionality</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Logging in and out of website</li>
                            <li>Editing of User's Profile</li>
                            <li>CRUD Output/Suboutput/Target/Rating (IPCR)</li>
                            <li>CRUD Output/Suboutput/Target/Rating (OPCR)</li>
                            <li>View list of user with the same office</li>
                            <li>View selected user's IPCR</li>
                            <li>CRUD Standard</li>
                            <li>Submit IPCR/STANDARD/OPCR and Approved or Decline by your head</li>
                            <li>CRUD Tracking Tool for Monitoring Assigment and can be mark as done</li>
                            <li>Duration of semester for IPCR/OPCR/STANDARD/TTMA/APPROVAL</li>
                            <li>Differentiate the IPCR of STAFF and FACULTY</li>
                            <li class="text-danger fst-italic">Add Get OUTPUT/SUBOUTPUT/TARGET for FACULTY</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All UI (red = unfinished/not worked yet) | Checked if added complete
                            function</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Individial Performance Commitment and Review <i class="bi bi-check2"></i></li>
                            <li>Standard <i class="bi bi-check2"></i></li>
                            <li>Officemates <i class="bi bi-check2"></i></li>
                            <li>For approval <i class="bi bi-check2"></i></li>
                            <li>Tracking Tool for Monitoring Assignments <i class="bi bi-check2"></i></li>
                            <li>Office Performance Commitment and Review <i class="bi bi-check2"></i></li>
                            <li>Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
