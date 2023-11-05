<li class="nav-item">
    <!-- data-target 要對應 下面的id   -->
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#teacher-lesson"
        aria-expanded="true" aria-controls="collapseTwo">
        <!-- fontawesome -->
        <i class="fa-solid fa-person-chalkboard sideicon"></i>
        <span>講師管理</span>
    </a>
    <!-- id 要對應 上面的 data-target  -->
    <div id="teacher-lesson" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Teacher Option</h6>
            <a class="collapse-item" href="teacher-list.php">講師清單</a>
            <a class="collapse-item" href="teacher-create.php">新增講師資訊</a>
            
        </div>
    </div>
</li>