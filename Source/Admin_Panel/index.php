<!-- 
Template file and landing page for this application to include the content.php using 
include function for include header, content and footer.php
-->
<?php include 'header.php'; ?>
   <div id="page-wrapper">
      <div class="container-fluid">
         <!-- Page Heading -->
         <div class="row" id="main" >
            <div class="col-sm-12 col-md-12" id="content">
                  <?php include 'content.php'; ?>
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