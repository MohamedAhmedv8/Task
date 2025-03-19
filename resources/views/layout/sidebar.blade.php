<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">Home</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('home')? 'active' :'' }}"><a class="nav-link" href="{{ route('home') }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Home"><i class="fa fa-home"></i> <span>Home</span></a></li>
        </ul>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('/note/create')? 'active' :'' }}"><a class="nav-link" href="{{ route('note_create') }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Home"><i class="fa fa-home"></i> <span>Create Note</span></a></li>
        </ul>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('notes')? 'active' :'' }}"><a class="nav-link" href="{{ route('note_view') }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Home"><i class="fa fa-home"></i> <span>Notes</span></a></li>
        </ul>







    </aside>
</div>