<!-- Recent Orders Page-->
<h2>Recent Orders</h2>
<table class="table table-borderd">
   <tr>
      <th>Name</th>
      <th>Menu</th>
      <th>Order Status</th>
   </tr>
   <?php
   /**
    * Content.php
    * On this file we are grabbing data from the mongo database
    * */

   // Initiate the DB connection string
   include 'config.php';

   // Selecting the User Records from the Mongo DB
   $collection = $client->restaurants->users;
   
   // Saving user records as objets into $users variable
   $users = $collection->find([]);

   // itterate the $users via foreach loop to perform the data in order to present on the webpage
   foreach ($users as $key => $val ) {

      // checking orders if isset and not empty
      if (isset($val->orders)) {
         //$i is to save the iterative number into $i 
         $i = 0;

         // Beautifying and cleaning the json record using json_decode and json_encode
         /**
          * The json_encode, json_decode() function is an inbuilt function in PHP which is used to decode a JSON string. It converts a JSON encoded string into a PHP variable.
          * iterator_to_array(Traversable $iterator , bool $preserve_keys = true ): array. Copy the elements of an iterator into an array.
          *  */ 
         $order_data = json_decode(json_encode(iterator_to_array($val->orders)), TRUE);

         // Business logic to get the order count - 1
         $order_count = count($order_data) - 1;

         // Performing business logic using for loop
         for ($i = 0; $i<=$order_count; $i++) {

            // $order_status is use to save the order status into variable
            $order_status = $order_data[$i]['status'];

            // $order_id to save id from the for loop via $order_data
            $order_id = $order_data[$i]['_id'];
            
            //getting menu count how many items are in the menu
            $menu_count = count($order_data[$i]['menu']) - 1;

            // if $status is available 
            if ($order_status) {

               // for display the data into pretty form at web page 
               echo "<tr>";
                  echo "<td>".$val->username."</td>";              
                  echo "<td>";
                  $total_price = 0;
                  for ($j = 0; $j<=$menu_count; $j++) {
                     if (isset($order_data[$i]['menu'][$j]['hotel'])) {
                        $total_price += $order_data[$i]['menu'][$j]['price'];
                        echo "Hotel Name: ". $order_data[$i]['menu'][$j]['name'] . "<br/>";
                        echo "Food: ". $order_data[$i]['menu'][$j]['name'] . "<br/>";
                        echo "Quantity: ". $order_data[$i]['menu'][$j]['quantity'] . "<br/>";
                     }
                  }
                  echo "Total: $". number_format($order_data[$i]['amountPaid'],2) . "<br/>";
                  "</td>";
                  echo "<td>";
                  ?>
                  <!-- Select Drop Down and Upon change the drop down value it will trigger the function status_change -->
                  <select name='status' id='status_<?php echo $order_id['$oid'];?>' class='form-control' onchange="status_change('<?php echo $order_id['$oid'];?>');">
                     <option value="">Status</option>
                     <option value="pending" <?php if ($order_status == 'pending') { echo 'selected=selected""';} ;?>>Pending</option>
                     <option value="completed" <?php if ($order_status == 'completed') { echo 'selected=selected""';} ;?>>Completed</option>
                  </select>

                  <?php
                  "</td>";
               echo "</tr>";
            }
         }
      }
   }
   ?>
</table>


<script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery Library to Perform the Ajax -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Sweet Alert to Show the Interactive Alerts -->
<script type="text/javascript">
// Change order status if via select drop down change
function status_change(order_id) {

   // status to get the order status
   var status = $("#status_"+order_id).val();

   // if status is not empty
   if (status !='') {

      // creating data array to post via ajax request
      var data = {
         'id' : order_id,
         'status' : status
      };
      // end creating data array to post via ajax request

      // ajax request
      $.ajax({
         url: "update_order.php",
         type: "post",
         data: data ,
         success: function (response) {
            // upon success it will show the alert
            Swal.fire({
               icon: 'success',
               title: 'Congrats!!!',
               text: 'Order Updated Successfully'
            })
         }  
      });
      // end ajax request
   }   
} // End function status_change(order_id) 
</script>