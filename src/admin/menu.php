<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-white">Xin chào <?php echo $_SESSION["user"]["username"] ?></div>
                    <?php 
                        if($_SESSION["user"]["role"] == 1) {
                    ?>
                    <a class="nav-link" href="doanh_thu.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Thống kê doanh thu
                    </a>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#hoadon"
                        aria-expanded="false" aria-controls="hoadon">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Quản lý đơn hàng
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="hoadon" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./order-list.php">Danh sách đơn hàng</a>
                            <a class="nav-link" href="./order-list-pending.php">Danh sách đơn hàng chưa xử lý</a>
                            <a class="nav-link" href="./order-list-success.php">Danh sách đơn hàng đã giao</a>
                            <a class="nav-link" href="./order-list-cancel.php">Danh sách đơn hàng đã huỷ</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                        aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Quản lý danh mục
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./category-list.php">Danh sách danh mục</a>
                            <a class="nav-link" href="./category-add.php">Thêm danh mục</a>
                            <a class="nav-link" href="./category-lock-list.php">Danh sách danh mục đã xoá</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts1"
                        aria-expanded="false" aria-controls="collapseLayouts1">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Quản lý loại sản phẩm
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./brand-list.php">Danh sách loại sản phẩm</a>
                            <a class="nav-link" href="./brand-add.php">Thêm loại sản phẩm</a>
                            <a class="nav-link" href="./brand-lock-list.php">Danh sách loại sản phẩm đã xoá</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2"
                        aria-expanded="false" aria-controls="collapseLayouts2">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Quản lý sản phẩm
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./product-list.php">Danh sách sản phẩm</a>
                            <a class="nav-link" href="./product-add.php">Thêm sản phẩm</a>
                            <a class="nav-link" href="./product-lock-list.php">Danh sách sản phẩm đã xoá</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts4"
                        aria-expanded="false" aria-controls="collapseLayouts4">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Quản lý kho hàng
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts4" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./storage-list.php">Danh sách kho hàng</a>
                            <a class="nav-link" href="./storage-list-empty.php">Danh sách kho hàng trống</a>
                            <a class="nav-link" href="./storage-add.php">Thêm kho hàng</a>
                            <!--<a class="nav-link" href="./product-lock-list.php">Danh sách sản phẩm đã xoá</a>-->
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts3"
                        aria-expanded="false" aria-controls="collapseLayouts3">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Quản lý người dùng
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./user-list.php">Danh sách  người dùng</a>
                            <a class="nav-link" href="./user-lock-list.php">danh sách tài khoản bị khoá</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" target="_blank" href="https://dashboard.tawk.to/?lang=vi#/chat"
                        aria-expanded="false" aria-controls="collapseLayouts3">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Liên Hệ
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <?php 
                        } else {
                            
                    ?>
                     <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#hoadon"
                        aria-expanded="false" aria-controls="hoadon">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Quản lý đơn hàng
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="hoadon" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./order-list.php">Danh sách đơn hàng</a>
                            <a class="nav-link" href="./order-list-pending.php">Danh sách đơn hàng chưa xử lý</a>
                            <a class="nav-link" href="./order-list-success.php">Danh sách đơn hàng đã giao</a>
                            <a class="nav-link" href="./order-list-cancel.php">Danh sách đơn hàng đã huỷ</a>
                        </nav>
                    </div>
                     <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2"
                        aria-expanded="false" aria-controls="collapseLayouts2">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Quản lý sản phẩm
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./product-list.php">Danh sách sản phẩm</a>
                            <a class="nav-link" href="./product-add.php">Thêm sản phẩm</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts3"
                        aria-expanded="false" aria-controls="collapseLayouts3">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Quản lý kho hàng
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./storage-list.php">Danh sách kho hàng</a>
                            <a class="nav-link" href="./storage-list-empty.php">Danh sách kho hàng trống</a>
                            <a class="nav-link" href="./storage-add.php">Thêm kho hàng</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" target="_blank" href="https://dashboard.tawk.to/?lang=vi#/chat"
                        aria-expanded="false" aria-controls="collapseLayouts3">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Liên Hệ
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <?php }
                    ?>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Sản phẩm được thiết kế bởi: Nguyễn Văn Phúc</div>
            
            </div>
        </nav>
    </div>