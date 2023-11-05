<li class="nav-item">
    <!-- data-target 要對應 下面的id   -->
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Couponbar" aria-expanded="true" aria-controls="collapseTwo">
        <!-- fontawesome -->
        <i class="fa-solid fa-ticket sideicon"></i>
        <span>優惠券管理</span>
    </a>
    <!-- id 要對應 上面的 data-target  -->
    <div id="Couponbar" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Coupon Option</h6>
            <a class="collapse-item" href="coupon-list.php">優惠券列表</a>
            <a class="collapse-item" href="coupon-create.php">新增優惠券</a>
            <a class="collapse-item" href="coupon-search.php">搜尋優惠券</a>
            <a class="collapse-item" href="coupon-edit-list.php">編輯優惠券</a>
        </div>
    </div>
</li>