<?php
   /** 
    * Hotel Details Page which will show the the name location and menu prices
    * */
   ?>
<?php
   // Getting ID Hotel Sent from Hotel List 
   $hotel_id = $_GET['id'];
   
   // Checking Hotel ID Exists
   if (empty($hotel_id)) {
      // If not exists it will redirect to hotel page
      header("Location: http://localhost/crm//hotels.php");
      die();
   }
   ?>
<?php
   // Mongo DB connections strings
   include 'config.php';
   
   // Fetching Hotels
   $collection = $client->restaurants->hotels;
   
   // Filter the selected hotel against the Hotel ID $hotel_id
   $hotel = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($hotel_id)]);
   ?>
<?php include 'header.php'; ?>
<div id="page-wrapper">
   <div class="container-fluid">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:right;">
      Add Menu
      </button>
      <!-- Page Heading -->
      <div class="row" id="main" >
         <div class="col-sm-12 col-md-12" id="content">
            <!-- Print the Data -->
            <h5><i>Name: <?php echo $hotel->name;?></i></h5>
            <h5><i>Address: <?php echo $hotel->address;?></i></h5>
            <h5><i>Speciality: <?php echo $hotel->cuisines;?></i></h5>
            <table class="table table-borderd">
               <tr>
                  <th>Dish</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Action</th>
               </tr>
               <?php
                  // Cleaning the special characters if exists
                  function clean($string) {
                   $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
                   $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , ' ', $string);
                   return strtolower(trim($string, ' '));
                  }
                  

                  // Hotel menu array iterate to view on the web page
                  foreach ($hotel->menu as $key => $val ) {
                     
                     $desc = clean( $val->desc );
                     
                     echo "<tr>";
                     echo "<td>".$val->name."</td>";  
                     echo "<td>".$desc."</td>";  
                     echo "<td>$".number_format($val->price,2)."</td>"; 
                     
                     ?>
               <td>
                  <a href="#" onclick='get_edit_menu("<?php echo $val->id;?>","<?php echo $val->name;?>","<?php echo $desc;?>","<?php echo $val->price;?>")'>Edit</a>
                  <a href="http://localhost/crm//delete_menu.php?menu_id=<?php echo $val->id;?>&hotel_id=<?php echo $hotel_id;?>">Delete</a>
               </td>
               <?php
                  echo "<tr/>";
                  }
                  ?>
            </table>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <form action="add_menu.php" method="POST">
                        <div class="modal-body">
                           <input type="text" name="name" id="name" required="required" placeholder="Menu Name" class="form-control"> <br>
                           <input type="text" name="desc" id="desc" required="required" placeholder="Enter Description" class="form-control"> <br>
                           <input type="number" name="price" id="price" required="required" placeholder="Menu Price" class="form-control"> <br>
                           <input type="hidden" name="hotel_id" value="<?php echo $hotel_id; ?>">
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<div class="modal fade" id="editMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <input type="text" name="edit_name" id="edit_name" required="required" placeholder="Menu Name" class="form-control"> <br>
            <input type="text" name="edit_desc" id="edit_desc" required="required" placeholder="Enter Description" class="form-control"> <br>
            <input type="number" name="edit_price" id="edit_price" required="required" placeholder="Menu Price" class="form-control"> <br>
            <input type="hidden" name="edit_menu_id" id="edit_menu_id" required="required" placeholder="Menu Price" class="form-control"> <br>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="my_custom_edit">Save changes</button>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
   // get_edit_menu is to open menu details on Modal popup 
   function get_edit_menu(menu_id,name,desc,price) {
      jQuery.noConflict(); 
      $('#editMenu').modal('show');
   
      $("#edit_name").val(name);
      $("#edit_desc").val(desc);
      $("#edit_price").val(price);
      $("#edit_menu_id").val(menu_id);     
      
   }
   // end get_edit_menu is to open menu details on Modal popup 
   
   
   $(document).ready(function(){
      $("#my_custom_edit").on('click',function(){
         // Variable to get the menu data from the modal input boxes and saving into JS variable to perform the ajax request
         var edit_name = $("#edit_name").val();
         var edit_desc = $("#edit_desc").val();
         var edit_price = $("#edit_price").val();
         var edit_menu_id = $("#edit_menu_id").val();
   
         
         // creating posting data to sent to php file via ajax request
         var data = {
            'hotel_id' : '<?php echo $hotel_id;?>',
            'edit_name' : edit_name,
            'edit_desc' : edit_desc,
            'edit_price' : edit_price,
            'edit_menu_id' : edit_menu_id
         };


         // ajax request start to send the data
         $.ajax({
            url: "get_edit_menu.php",
            type: "post",
            data: data ,
            success: function (response) {
               location.reload();   
            }  
         });
         // end ajax request start to send the data
         
      });
   });
</script>
<?php include 'footer.php'; ?>