<li class="nav-item">
    <a class="nav-link" href="{{ route('users') }}">{{ __('User') }}</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('roles') }}">{{ __('Role') }}</a>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ __('Products') }}
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="nav-link" href="">{{ __('Products') }}</a>
        <a class="nav-link" href="">{{ __('Product Type') }}</a>
        <a class="nav-link" href="">{{ __('Product Family') }}</a>
        <a class="nav-link" href="">{{ __('Category') }}</a>
        <a class="nav-link" href="">{{ __('Brand') }}</a>
        <a class="nav-link" href="">{{ __('Color') }}</a>
        <a class="nav-link" href="">{{ __('Sizes') }}</a>
    </div>
</li>