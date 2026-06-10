<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon">
            <img src="{{ asset((setting('logo')) ? '/storage/'.setting('logo') : 'dist/img/logo/logo2.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">TBCare</div>
    </a>
    <hr class="sidebar-divider my-0">

    @can('dashboard')
    <x-nav-link 
        text="Dashboard" 
        icon="th" 
        url="{{ route('admin.dashboard') }}"
        active="{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}"
    />

    <hr class="sidebar-divider mt-3 mb-0">
    @endcan
    
    {{-- HAPUS atau komentari blok ini (menu CF lama) --}}
    {{--
    @can('diagnosa')    
    <x-nav-link 
        text="Prediksi TBC (Admin)" 
        icon="stethoscope" 
        url="{{ route('admin.diagnosa') }}"
        active="{{ request()->routeIs('admin.diagnosa') ? ' active' : '' }}"
    />
    @endcan
    --}}
    
    {{-- Menu untuk role USER: prediksi ML --}}
    @role('user')
    <x-nav-link
        text="Prediksi Risiko TBC"
        icon="heartbeat"
        url="{{ route('users.prediksi.create') }}"
        active="{{ request()->routeIs('users.prediksi.create', 'users.prediksi.store') ? ' active' : '' }}"
    />
    <x-nav-link
        text="Riwayat Prediksi Saya"
        icon="history"
        url="{{ route('users.prediksi.index') }}"
        active="{{ request()->routeIs('users.prediksi.index', 'users.prediksi.show') ? ' active' : '' }}"
    />
    <x-nav-link
        text="ChatBot TBC"
        icon="robot"
        url="{{ route('users.chatbot') }}"
        active="{{ request()->routeIs('users.chatbot', 'users.chatbot.prediksi', 'users.chatbot.send', 'users.chatbot.reset') ? ' active' : '' }}"
    />
    <x-nav-link
        text="Artikel TBCare"
        icon="newspaper"
        url="{{ route('users.artikel.index') }}"
        active="{{ request()->routeIs('users.artikel.index', 'users.artikel.show') ? ' active' : '' }}"
    />
    @endrole

    {{-- Menu untuk role ADMIN: log aktivitas prediksi ML --}}
    @role('Admin')
    <x-nav-link
        text="Log Prediksi TBC"
        icon="clipboard-list"
        url="{{ route('admin.prediksi') }}"
        active="{{ request()->routeIs('admin.prediksi') ? ' active' : '' }}"
    />
    @endrole
    
    <!-- @can('riwayat-list')
    <x-nav-link 
        text="Riwayat Diagnosa" 
        icon="notes-medical" 
        url="{{ route('admin.riwayat.daftar') }}"
        active="{{ request()->routeIs('admin.riwayat.daftar') ? ' active' : '' }}"
    />
    @endcan -->

    @can('member-list')
    <hr class="sidebar-divider mt-3 mb-0">
    
    <x-nav-link 
        text="Daftar User" 
        icon="users" 
        url="{{ route('admin.member') }}"
        active="{{ request()->routeIs('admin.member') ? ' active' : '' }}"
    />
    @endcan

    @can('fasilitasKesehatan-list')
    <x-nav-link 
        text="Daftar Fasilitas Kesehatan" 
        icon="th-list" 
        url="{{ route('admin.fasilitasKesehatan') }}"
        active="{{ request()->routeIs('admin.fasilitasKesehatan') ? ' active' : '' }}"
    />
    @endcan

    @can('artikel-list')
    <x-nav-link 
        text="Daftar Artikel" 
        icon="th-list" 
        url="{{ route('admin.artikel.index') }}"
        active="{{ request()->routeIs('admin.artikel.index') ? ' active' : '' }}"
    />
    @endcan

    @can('feedback-list')
    <x-nav-link 
        text="Feedback" 
        icon="comment-dots" 
        url="{{ route('admin.feedback.index') }}"
        active="{{ request()->routeIs('admin.feedback.index') ? ' active' : '' }}"
    />
    @endcan

    @can('monitoring-list')
    <x-nav-link 
        text="Monitoring" 
        icon="heartbeat" 
        url="{{ route('admin.monitoring.index') }}"
        active="{{ request()->routeIs('admin.monitoring.index') ? ' active' : '' }}"
    />
    @endcan

    @can('rules-list')
    <x-nav-link 
        text="Basis Rules" 
        icon="briefcase-medical" 
        url="{{ route('admin.rules', 1) }}"
        active="{{ request()->routeIs('admin.rules') ? ' active' : '' }}"
    />
    @endcan
    
    <hr class="sidebar-divider mb-0">

</ul>