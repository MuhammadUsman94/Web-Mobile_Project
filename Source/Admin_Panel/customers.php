<?php include 'header.php'; ?> <!-- Including Header.php to load the html template -->
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row" id="main" >
         <div class="col-sm-12 col-md-12" id="content">
            <h1>Customers</h1>
            <table class="table table-sm">
               <tr>
                  <th>Name</th>
                  <th>Email</th>
               </tr>
               <?php
                  // Initiate the DB connection string
                  include 'config.php';

                  // Selecting the User Records from the Mongo DB
                  $collection = $client->restaurants->users;

                  // Saving user records as objets into $users variable
                  $users = $collection->find([]);

                  // itterate the $users via foreach loop to perform the data in order to present on the webpage
                  foreach ($users as $key => $val ) {
                     echo "<tr>";
                        echo "<td>".$val->username."</td>";              
                        echo "<td>".$val->email."</td>";
                  ?>
                  <?php
                  echo "</tr>";
                  }
                  ?>
            </table>
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