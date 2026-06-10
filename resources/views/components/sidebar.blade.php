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
    
    @can('diagnosa')    
    <x-nav-link 
        text="Prediksi TBC" 
        icon="stethoscope" 
        url="{{ route('admin.diagnosa') }}"
        active="{{ request()->routeIs('admin.diagnosa') ? ' active' : '' }}"
    />
    @endcan
    
    @can('riwayat-list')
    <x-nav-link 
        text="Riwayat Prediksi TBC" 
        icon="notes-medical" 
        url="{{ route('admin.riwayat.daftar') }}"
        active="{{ request()->routeIs('admin.riwayat.daftar') ? ' active' : '' }}"
    />
    @endcan

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
        url="{{ route('admin.artikel') }}"
        active="{{ request()->routeIs('admin.artikel') ? ' active' : '' }}"
    />
    @endcan

    @can('feedback-list')
    <x-nav-link 
        text="Feedback" 
        icon="comment-dots" 
        url="{{ route('admin.feedback') }}"
        active="{{ request()->routeIs('admin.feedback') ? ' active' : '' }}"
    />
    @endcan

    @can('monitoring-list')
    <x-nav-link 
        text="Monitoring" 
        icon="heartbeat" 
        url="{{ route('admin.monitoring') }}"
        active="{{ request()->routeIs('admin.monitoring') ? ' active' : '' }}"
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
    
    @if(auth()->user()->hasRole('Admin'))
    <x-nav-link 
        text="Forum" 
        icon="comments" 
        url="{{ route('admin.forum') }}"
        active="{{ request()->routeIs('admin.forum*') ? ' active' : '' }}"
    />
    @else
    <x-nav-link 
        text="Feedback" 
        icon="comment-dots" 
        url="{{ route('user.feedback') }}"
        active="{{ request()->routeIs('user.feedback*') ? ' active' : '' }}"
    />
    <x-nav-link 
        text="Forum" 
        icon="comments" 
        url="{{ route('user.forum') }}"
        active="{{ request()->routeIs('user.forum*') ? ' active' : '' }}"
    />
    @endif
    
    <hr class="sidebar-divider mb-0">

</ul>