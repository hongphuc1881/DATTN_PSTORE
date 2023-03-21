<?php
session_start();
if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
    include("./database.php");
    include("./header.php");
    include("./menu.php");
    include("./footer.php");
    include("./class/user-class.php");
?>

<?php 
    $User = new User;
    $show_user = $User->show_user();

     // phan trang
    // 1.tong so ban ghi
    $total_user = $show_user->num_rows;
    // 2. thiet lap so ban ghi tren 1 trang
    $limit = 8;
    // 3. tinh so trang 
    $page = ceil($total_user/$limit);
    // 4. lay trang hien tai
    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1 ;

    //5. start
    $start = ($current_page - 1) * $limit;
    //6: query
    $user_pagination = $User->user_pagination($limit, $start);
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Danh sách người dùng</h2>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col" style="width: 5%">#</th>
                    <th scope="col" style="width: 10%">Username</th>
                    <th scope="col" style="width:20%">Full Name</th>
                    <th scope="col" style="width: 20%">Email</th>
                    <th scope="col" style="width: 5%">Quyền</th>
                    <th scope="col" style="width: 15%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <!--<?php 
                        if($show_user) {
                            $i = 0;
                            while($result = $show_user->fetch_assoc()) {
                                $i++;
                    ?>
                      <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["username"] ?></td>
                        <td><?php echo $result["fullname"] ?></td>
                        <td><?php echo $result["email"] ?></td>
                        <td><?php echo $result["role_name"] ?></td>
                        <td>
                        <a href="user-edit.php?user_id=<?php echo $result['user_id'] ?>" class="btn btn-dark">Sửa</a>
                        <a href="user-delete.php?user_id=<?php echo $result['user_id'] ?>" class="btn btn-danger">Xoá</a>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    ?>-->


                    <?php
                        if($user_pagination) {
                            $i = 0;
                            while($result = $user_pagination->fetch_assoc()) { 
                                $i++; 
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["username"] ?></td>
                        <td><?php echo $result["fullname"] ?></td>
                        <td><?php echo $result["email"] ?></td>
                        <td><?php echo $result["role_name"] ?></td>
                        <td>
                        <a href="user-edit.php?user_id=<?php echo $result['user_id'] ?>" class="btn btn-dark">Sửa</a>
                        <a href="user-delete.php?user_id=<?php echo $result['user_id'] ?>" class="btn btn-danger">Xoá</a>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                     ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php 
                            if($current_page - 1 > 0) {
                         ?>
                            <li class="page-item">
                                <a class="page-link" href="user-list.php?page=<?php  echo $current_page -1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php 
                            for ($i=1; $i <= $page ; $i++) { 
                        ?>
                                <li class="page-item <?php echo $i == $current_page ? "active": ""?>"><a class="page-link" href="user-list.php?page=<?php echo $i ?>"><?php echo  $i ?></a></li>
                        <?php 
                                }   
                        ?>
                        
                        <?php
                            if($current_page + 1 <= $page) {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="user-list.php?page=<?php echo $current_page + 1;?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
                </nav>
          
            </div>
        </div>
    </main>
</div>
</div>

<?php 

    } else {
        include("./404.php");
    }
?>

