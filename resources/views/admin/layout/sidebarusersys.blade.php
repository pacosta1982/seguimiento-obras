


<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.guest.home') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/projects') }}"><i class="nav-icon fa fa-plus-circle"></i> {{ trans('admin.guest.projects') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/files') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.guest.files') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/applicants') }}"><i class="nav-icon icon-graduation"></i> {{ trans('admin.guest.applicants') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/beneficiaries') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.guest.beneficiaries') }}</a></li>
        <!--<li class="nav-item"><a class="nav-link" href="{{ url('/reports') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.guest.reports') }}</a></li>-->
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
