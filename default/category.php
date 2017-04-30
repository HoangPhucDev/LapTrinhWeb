 
 <?php 
            include_once '../class/Model.php';
            $data = new Model();
            $size = 6;
            $name = isset($_GET['tukhoa'])?$_GET['tukhoa']:'';
             if(isset($name)){
                   $result = $data->get_row("SELECT COUNT(*) FROM `products` WHERE `name` LIKE '%$name%' OR `price` = '$name'");
             }else {
                $result = $data->get_row("SELECT COUNT(*) FROM `products`");
             }
            $tongsosanpham = $result['COUNT(*)'];
            $tongsotrang = ceil($tongsosanpham / $size);
?>
<?php include_once 'general/header.php';?>
 <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-3">
                    <!-- *** MENUS AND FILTERS ***
 _________________________________________________________ -->
                  <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Danh mục</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked category-menu">
                                <?php include_once 'category_full.php';?>
                            </ul>

                        </div>
                    </div>

                    <!-- *** MENUS AND FILTERS END *** -->

                    <div class="banner"></div>
                </div>

                <div class="col-md-9">
                               <div class="box info-bar">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 products-showing">
                                Hiển Thị <strong><?php echo $size;?></strong> Trong <strong><?php echo $tongsosanpham;?></strong> Sản Phẩm
                            </div>

                            <div class="col-sm-12 col-md-8  products-number-sort">
                                <div class="row">
                                    <form class="form-inline">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="products-number">
                                                <strong>Hiển Thị</strong>  <a href="#" class="btn btn-default btn-sm btn-primary"><?php echo $size;?></a>  <a href="#" class="btn btn-default btn-sm"><?php echo $tongsosanpham;?></a>  <a href="#" class="btn btn-default btn-sm">All</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="products-sort-by">
                                                <strong>Sắp Xếp Theo</strong>
                                                <select name="sort-by" class="form-control">
                                                    <option>Giá</option>
                                                    <option>Tên</option>
                                                    <option>Bán nhiều</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row products">
                        <?php include 'product-list.php';?>
                    </div>
                    <!-- /.products -->

                    <div class="pages">
                        <ul class="pagination">   
                        
                            <li><a href="#">&laquo;</a>
                            </li>
                                <?php 
                                     for($i = 1; $i<= $tongsotrang; $i++){
                                         echo   "<li><a href=\"?trang=$i\">$i</a>
                                                </li>";
                                       }
                                 ?>
                            <li><a href="#">&raquo;</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.col-md-9 -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
    <?php include_once 'general/footer.php';?>
    </div>
   <?php include_once 'general/script.php';?>
</body>

</html>