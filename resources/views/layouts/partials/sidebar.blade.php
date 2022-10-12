<x-maz-sidebar :href="route('dashboard')" :logo="asset('images/logo/logo.png')">

    <!-- Add Sidebar Menu Items Here -->

    <x-maz-sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-grid-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Officemates" :link="route('officemates')" icon="bi bi-people-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="For Approval" :link="route('for-approval')" icon="bi bi-person-lines-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Tracking Tool" :link="route('ttma')" icon="bi bi-clipboard2-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="IPCR - Staff" :link="route('ipcr.staff')" icon="bi bi-clipboard2-data-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Standard - Staff" :link="route('standard.staff')" icon="bi bi-clipboard-data-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="IPCR - Faculty" :link="route('ipcr.faculty')" icon="bi bi-clipboard2-data-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Standard - Faculty" :link="route('standard.faculty')" icon="bi bi-clipboard-data-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="OPCR" :link="route('opcr')" icon="bi bi-clipboard2-data-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Configure" :link="route('configure')" icon="bi bi-nut-fill"></x-maz-sidebar-item>


</x-maz-sidebar>