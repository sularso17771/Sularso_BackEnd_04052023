@php
$configData = Helper::applClasses();
@endphp
{{-- Horizontal Menu --}}
<div class="horizontal-menu-wrapper">
  <div class="header-navbar navbar-expand-sm navbar navbar-horizontal
  {{$configData['horizontalMenuClass']}}
  {{($configData['theme'] === 'dark') ? 'navbar-dark' : 'navbar-light' }}
  navbar-shadow menu-border
  {{ ($configData['layoutWidth'] === 'boxed' && $configData['horizontalMenuType']  === 'navbar-floating') ? 'container-xxl' : '' }}"
  role="navigation"
  data-menu="menu-wrapper"
  data-menu-type="floating-nav">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item me-auto">
          <a class="navbar-brand" href="{{url('/')}}">
            <span class="brand-logo">
              <img src="{{ asset('images/logo/hanya-logo.png')}} " alt="#">    
            </span>
            <h2 class="brand-text mb-0">
              <img src="{{ asset('images/logo/hanya_huruf.png')}} " alt="#">
            </h2>
          </a>
        </li>
        <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
            <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="shadow-bottom"></div>
      <div class="navbar-container main-menu-content" data-menu="menu-container">
        <!-- include includes/mixins-->
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="dropdown nav-item active">
            <a class=" nav-link d-flex align-items-center" href="dashboard-kaum-guru-ngaji.html">
              <i data-feather="home"></i>
              <span data-i18n="User Interface">Dashboard</span>
            </a>
          </li>
          <li class="dropdown nav-item" data-menu="dropdown">
            <a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">
              <i data-feather="external-link"></i>
              <span data-i18n="User Interface">Kegiatan</span>
            </a>
            <ul class="dropdown-menu" data-bs-popper="none">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="kegiatan-kaum.html" data-bs-toggle="" data-i18n="wifi">
                  <i data-feather="file-text"></i>
                  <span data-i18n="wifi">Preview Ustad/Ustadzah</span>
                </a>
              </li>
              <li class="">
                <a class="dropdown-item d-flex align-items-center" href="kegiatan-guru-ngaji.html" data-bs-toggle="" data-i18n="Feather">
                  <i data-feather="hard-drive"></i>
                  <span data-i18n="Feather">Preview Guru Agama</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="dropdown nav-item" data-menu="dropdown">
            <a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">
              <i data-feather="layers"></i>
              <span data-i18n="User Interface">Kelola Kegiatan</span>
            </a>
            <ul class="dropdown-menu" data-bs-popper="none">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="kelola-rekap-murid-role-guru-ngaji-dan-kaum.html" data-bs-toggle="" data-i18n="Feather">
                  <i data-feather="hard-drive"></i>
                  <span data-i18n="Feather">Rekap Hadir Murid</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
  </div>
</div>
