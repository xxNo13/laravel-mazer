<x-maz-sidebar :href="route('dashboard')" :logo="asset('images/logo/logo.png')">

    <!-- Add Sidebar Menu Items Here -->

    <x-maz-sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-grid-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Tracking Tool for Monitoring Assingments" :link="route('ttma')" icon="bi bi-clipboard2-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Training Recommendation" :link="route('training.recommendation')" icon="bi bi-person-video3"></x-maz-sidebar-item>
    @if (Auth::user()->office->office == 'PMO')
        <x-maz-sidebar-item name="Agency's Target" :link="route('agency.target')" icon="bi bi-person-circle"></x-maz-sidebar-item>
    @endif
    @if (Auth::user()->account_types->contains(3) || Auth::user()->account_types->contains(4))
        <x-maz-sidebar-item name="Subordinates" :link="route('officemates')" icon="bi bi-people-fill"></x-maz-sidebar-item>
        <x-maz-sidebar-item name="For Approval" :link="route('for-approval')" icon="bi bi-person-lines-fill"></x-maz-sidebar-item>
        <x-maz-sidebar-item name="OPCR" :link="route('opcr')" icon="bi bi-clipboard2-data-fill"></x-maz-sidebar-item>
        <x-maz-sidebar-item name="Standard - OPCR" :link="route('standard.opcr')" icon="bi bi-clipboard-data-fill"></x-maz-sidebar-item>
    @endif
    @if (Auth::user()->account_types->contains(2))
        <x-maz-sidebar-item name="IPCR - Staff" :link="route('ipcr.staff')" icon="bi bi-clipboard2-data-fill"></x-maz-sidebar-item>
        <x-maz-sidebar-item name="Standard - Staff" :link="route('standard.staff')" icon="bi bi-clipboard-data-fill"></x-maz-sidebar-item>
    @endif
    @if (Auth::user()->account_types->contains(1))
        <x-maz-sidebar-item name="IPCR - Faculty" :link="route('ipcr.faculty')" icon="bi bi-clipboard2-data-fill"></x-maz-sidebar-item>
        <x-maz-sidebar-item name="Standard - Faculty" :link="route('standard.faculty')" icon="bi bi-clipboard-data-fill"></x-maz-sidebar-item>
    @endif
    @if (Auth::user()->account_types->contains(5))
        <x-maz-sidebar-item name="IPCR - Faculty(ADD)" :link="route('ipcr.add.faculty')" icon="bi bi-clipboard2-data-fill"></x-maz-sidebar-item>
        <x-maz-sidebar-item name="Configure" :link="route('configure')" icon="bi bi-nut-fill"></x-maz-sidebar-item>
    @endif
    @if (Auth::user()->office->office == 'HRMO')
        <x-maz-sidebar-item name="Register User" :link="route('register.user')" icon="bi bi-person-plus-fill"></x-maz-sidebar-item>
    @endif

</x-maz-sidebar>