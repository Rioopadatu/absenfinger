<li class="nav-item">
    <a href="{{ route('fpUsers.index') }}"
       class="nav-link {{ Request::is('fpUsers*') ? 'active' : '' }}">
        <p>Fp Users</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('fpAttendances.index') }}"
       class="nav-link {{ Request::is('fpAttendances*') ? 'active' : '' }}">
        <p>Fp Attendances</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('fpIzins.index') }}"
       class="nav-link {{ Request::is('fpIzins.*') ? 'active' : '' }}">
        <p>Perizinan Karyawan</p>
    </a>
</li>


