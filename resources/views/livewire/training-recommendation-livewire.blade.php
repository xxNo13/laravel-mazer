<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Training Recommendation</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Training Recommendation</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-3">
        <div class="card">
            <div class="card-header hstack">
                <h4 class="card-title my-auto">List of Training</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-lg text-center">
                        <thead>
                            <tr>
                                <th>TRAININGS</th>
                                <th>LINKS</th>
                                <th>USER ADDED</th>
                                <th>POSSIBLE TARGETS</th>
                                <th>POSTED</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trainings as $training)
                                <tr>
                                    <td>{{ $training->training }}</td>
                                    <td>{{ $training->link }}</td>
                                    <td>{{ $training->user->name }}</td>
                                    <td>{{ $training->possible_target }}</td>
                                    <td>{{ $training->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No record available!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
