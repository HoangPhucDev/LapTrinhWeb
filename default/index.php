<?php include_once 'general/header.php';
include_once '../class/Model.php';
?>
    <div id="all">
        <div id="content">
            <?php include_once 'general/slider.php';?>               
                    <div id="hot">
               <?php                 
                    $data = new Model();
                    $sql = $data->get_list("select * FROM `category`");
              if(!empty($sql)){
                   foreach ($sql as $key =>$value){
                       echo ' <div class="box">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>'.$value['name'].'</h2>
                        </div>
                    </div>
                </div>';
                   }
              }
              ?>
<p>đã bỏ</p>
                <div class="container">
                    <div class="product-slider">
                             <!-- *** Load Sáº£n Pháº©m Trong Danh Má»¥c *** -->   
                    <?php
    
                    $query2 = $data->get_list("SELECT * FROM `products` INNER JOIN `category_detail` ON products.category = category_detail.id  WHERE `category_id` =".$value["id"]." LIMIT 0,10");


               foreach ($query2 as $value1){
                 echo '<div class="item">
                            <div class="product">
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <a href="detail.php?id='.$value1["id"].'">
                                                <img src="img/'.$value1["image"].'" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="back">
                                            <a href="detail.php?id='.$value1["id"].'">
                                                <img src="img/'.$value1["image"].'" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="detail.php?id='.$value1["id"].'" class="invisible">
                                    <img src="img/'.$value1["image"].'" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    <h3><a href="detail.php?id='.$value1["id"].'">'.$value1["name"].'</a></h3>
                                    <p class="price">'.number_format($value1['price']).' VNÄ�</p>
                                </div>
                                <!-- /.text -->
                            </div>
                            <!-- /.product -->
                        </div>' ;             

       }

?>

                       </div>

                     </div>
                  </div>
                </div>
            </div>
        <!-- /#content -->
        <?php include_once 'general/footer.php';?>
       <?php include_once 'general/script.php';?>
</body>
</html>