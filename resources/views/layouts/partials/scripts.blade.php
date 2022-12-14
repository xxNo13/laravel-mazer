<script src="{{ mix('js/app.js') }}"></script>

<script src="{{ asset('/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('/vendors/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('/vendors/toastify/toastify.js') }}"></script>
<script src="{{ asset('/vendors/apexcharts/apexcharts.js') }}"></script>


<script src="//unpkg.com/alpinejs" defer></script>
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
@livewireScripts
<script src="{{ asset('/js/main.js') }}"></script>

<script>
    window.addEventListener('close-modal', event => {
        $('#AddIPCROSTModal').modal('hide');
        $('#EditIPCROSTModal').modal('hide');
        $('#AddOPCROSTModal').modal('hide');
        $('#EditOPCROSTModal').modal('hide');
        $('#DeleteModal').modal('hide');
        $('#AddRatingModal').modal('hide');
        $('#EditRatingModal').modal('hide');
        $('#AddStandardModal').modal('hide');
        $('#EditStandardModal').modal('hide');
        $('#SubmitISOModal').modal('hide');
        $('#AssessISOModal').modal('hide');
        $('#AddTTMAModal').modal('hide');
        $('#EditTTMAModal').modal('hide');
        $('#DoneModal').modal('hide');
        $('#AddOfficeModal').modal('hide');
        $('#EditOfficeModal').modal('hide');
        $('#AddAccountTypeModal').modal('hide');
        $('#EditAccountTypeModal').modal('hide');
        $('#AddDurationModal').modal('hide');
        $('#EditDurationModal').modal('hide');
        $('#ResetIPCRModal').modal('hide');
        $('#AddPercentageModal').modal('hide');
        $('#EditPercentageModal').modal('hide');
        $('#DeletePercentageModal').modal('hide');
        $('#DisapproveModal').modal('hide');
        $('#MessageTTMAModal').modal('hide');
        $('#EditMessageTTMAModal').modal('hide');
        $('#AddTrainingModal').modal('hide');
        $('#EditTrainingModal').modal('hide');
        $('#EditScoreEqModal').modal('hide');
    });
</script>

{{ $script ?? ''}}

@stack('target')
@stack('assignment')
@stack('rating')