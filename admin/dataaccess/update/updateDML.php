<?php 
    require_once '../../../class/Model.php';
    $data = new Model();
    $id = $_GET['id'];
    $arrdm = $data->get_row("SELECT `id`,`name` FROM `category` WHERE `id`='$id'");
    if (isset($_POST['submit'])){
        $tendanhmuc = $_POST['danhmuc'];
        $update = $data->update('category',array('name' => $tendanhmuc), "`id`='$id'");
        if(isset($update)){
            header("Location: ../../danhmuclon.php");
        }else {
            echo "Sửa Thất bại";
        }
    }
    
    ?>
 <?php include_once '../general/header.php';?>
            <form id="form-update" action="" name="themdml" method="post">
                     <span class="title-table">Sửa Danh Mục Lớn</span>
                     <input type="hidden" name="textPage" value="1" id="textPageUpdate">
                     <input type="hidden" name="textAction" id="textAction" value="">
                     <span id="labelmessageForm" class="labelmessageForm"></span>
                     <div class="pnlUpdateAction">
                        <input type="submit" name="submit" value="Lưu" > | 
                         <input type="submit" name="submit" value="Trở Về">
                        <input style="display: none" type="submit" id="btnUpdateAction">
                     </div>   
                     <br>
                                          
                     <table class="update-table" cellspacing="0" cellpadding="0"><tbody>
                           <tr style="display: none;"><td class="update-td">
                              <td class="update-td"><input value="" readonly="" name="txtid" type="text" id="txtid">
                                 <span id="error-id" class="label-validate"></span></td></tr>
                           <tr><td class="update-td" style="width:150px;">
                                 <span class="update-header-td">Tên Danh Mục:</span></td>
                              <td class="update-td">
                                 <input style="width:300px" value="<?php echo $arrdm['name'];?>" name="danhmuc" type="text" maxlength="255" id="txtname">
                                 <span id="error-name" class="label-validate"></span></td></tr>
                        </tbody></table>
                  </form>
 </body>
 </html>