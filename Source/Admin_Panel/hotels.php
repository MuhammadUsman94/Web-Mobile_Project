<?php include 'header.php'; ?>
<div id="page-wrapper">
   <div class="container-fluid">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:right;">
      Add Hotel
      </button>
      <!-- Page Heading -->
      <div class="row" id="main" >
         <div class="col-sm-12 col-md-12" id="content">
            <h2>Hotels</h2>
            <table class="table table-borderd">
               <tr>
                  <th>Name</th>
                  <th>Address</th>
                  <th>View</th>
               </tr>
               <?php
                  // init connection string
                  include 'config.php';

                  // fetching hotel collection
                  $collection = $client->restaurants->hotels;

                  // saving data into variable
                  $hotels = $collection->find([]);

                  //loop the hotel data to present on the web page
                  foreach ($hotels as $key => $val ) {
                     echo "<tr>";
                        echo "<td>".$val->name."</td>";              
                        echo "<td>".$val->address."</td>";
                  ?>
               <td>
                  <a href="view_details.php?id=<?php echo $val->_id;?>" class="btn btn-success">View Menu</a>
                  <a href="delete_hotel.php?id=<?php echo $val->_id;?>" class="btn btn-danger">Delete Hotel</a>
               </td>
               <?php
                  echo "</tr>";
                  }
                  ?>
            </table>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Hotel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <form action="add_hotel.php" method="POST">
                        <div class="modal-body">
                           <input type="text" name="name" id="name" required="required" placeholder="Hotel Name" class="form-control" required="required"> <br>
                           <input type="text" name="address" id="address" required="required" placeholder="Enter Hotel Address" class="form-control" required="required"> <br>
                           <input type="text" name="cuisines" id="cuisines" required="required" placeholder="Enter Cuisines" class="form-control" required="required"> <br>
                           <input type="text" name="feature_image" id="feature_image" required="required" placeholder="Enter Feature Image URL" class="form-control" required="required"> <br>
                           <input type="text" name="thumbnail_image" id="thumbnail_image" required="required" placeholder="Enter Thumbnail Image URL" class="form-control" required="required"> <br>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script><!-- Jquery library to perform the js function-->
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script><!-- Alert Library to view the interactive alerts -->
            <script type="text/javascript">
               // this is ajax function to perfrom order status change
               function status_change(order_id) {

                  // getting the new order status upon drop down value change
                  var status = $("#status_"+order_id).val();

                  // if status is not empty
                  if (status !='') {

                     // creating array to post the data to php file
                     var data = {
                        'id' : order_id,
                        'status' : status
                     };

                     // start ajax 
                     $.ajax({
                        url: "update_order.php",
                        type: "post",
                        data: data ,
                        success: function (response) {
                           Swal.fire({
                              icon: 'success',
                              title: 'Congrats!!!',
                              text: 'Order Updated Successfully'
                           })
                        }  
                     });
                     // end ajax
                  }   
               }
            </script>
         </div>
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php include 'footer.php'; ?>