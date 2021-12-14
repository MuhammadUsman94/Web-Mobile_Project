<!DOCTYPE html>
<html>
<head>
   <title>Usman Project</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Usman Project</h1>
<table class="table table-borderd">
   <tr>
      <th>Name</th>
      <th>Menu</th>
      <th>Order Status</th>
   </tr>
   <?php
   include 'config.php';
   $collection = $client->restaurants->users;
   $users = $collection->find([]);
   foreach ($users as $key => $val ) {
      if (isset($val->orders)) {
         $i = 0;
         $order_data = json_decode(json_encode(iterator_to_array($val->orders)), TRUE);
         $order_count = count($order_data) - 1;
         for ($i = 0; $i<=$order_count; $i++) {
            $order_status = $order_data[$i]['status'];
            $order_id = $order_data[$i]['_id'];
            

            $menu_count = count($order_data[$i]['menu']) - 1;
            if ($order_status) {
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
                  echo "Total: $". number_format($total_price,2) . "<br/>";
                  "</td>";
                  echo "<td>";
                  ?>
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
</div>


<script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
function status_change(order_id) {
   var status = $("#status_"+order_id).val();
   if (status !='') {
      var data = {
         'id' : order_id,
         'status' : status
      };
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
   }   
}
</script>

</body>
</html>