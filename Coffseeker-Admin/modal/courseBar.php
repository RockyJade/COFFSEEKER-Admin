<li class="nav-item">
    <!-- data-target 要對應 下面的id   -->
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#coursebar"
        aria-expanded="true" aria-controls="collapseTwo">
        <!-- fontawesome -->
        <i class="fa-solid fa-book sideicon"></i>
        <span>課程管理</span>
    </a>
    <!-- id 要對應 上面的 data-target  -->
    <div id="coursebar" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Course Option</h6>
            <a class="collapse-item" href="course_list.php">課程列表</a>
            <a class="collapse-item" href="course_list.php?valid=2">已下架課程</a>
        </div>
    </div>
</li>