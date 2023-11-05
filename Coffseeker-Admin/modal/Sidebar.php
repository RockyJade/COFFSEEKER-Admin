<!-- Sidebar -->
<ul class="navbar-nav bg-milky sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
        <img class="logo" src="img/logo.svg" alt="">
    </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="index.php">
    <i class="fa-solid fa-indent"></i>
        <span>首頁</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    後台功能
</div>

<?php include("userbar.php"); ?>

<?php include("orderbar.php"); ?>

<?php include("categorybar.php"); ?>

<?php include("productbar.php"); ?>

<?php include("couponbar.php"); ?>

<?php include("teacherbar.php"); ?>

<?php include("coursebar.php"); ?>





<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    附加頁面
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder sideicon"></i>
        <span>其他頁面</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">前台</h6>
            <!-- <a class="collapse-item" href="login.php">登入</a> -->
            <a class="collapse-item" href="register.php">註冊</a>
            <!-- <a class="collapse-item" href="forgot-password.php">忘記密碼</a> -->
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">其他</h6>
            <a class="collapse-item" href="404.php">找不到404</a>
            <a class="collapse-item" href="blank.php">空白頁</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->