<nav class="navbar navbar-expand navbar-light px-0">
    <div class="container-fluid">
        <a href="<?= site_url()?>" class="burger-btn d-block">
			<img src="<?= site_url()?>assets/images/logo/logo.png" height="50" alt="Logo" srcset=""> 
        </a>

        <button class="navbar-toggler d-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown me-1">
                    <a class="nav-link dropdown-toggle dropdown-inbox" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                        <span class="alert-dot"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">البريد</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">No new mail</a></li>
                    </ul>
                </li>
            </ul>
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600"><?= $this->session->userdata("user_name")?></h6>
                            <p class="mb-0 text-sm text-gray-600"><?= $this->session->userdata("group_name")?></p>
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="<?= site_url().$this->session->userdata("user_pic")?>">
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li>
                        <h6 class="dropdown-header">مرحبا بك</h6>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= site_url()?>agent/profile">
                            <i class="icon-mid bi bi-person me-2"></i> حسابي
                        </a>
                    </li>
                    <hr class="dropdown-divider"> 
                    <li>
                        <a class="dropdown-item" href="<?= site_url("welcome/logout")?>">
                            <i class="icon-mid bi bi-box-arrow-left me-2"></i> تسجيل خروج
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>