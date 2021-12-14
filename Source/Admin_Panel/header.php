<!-- 
***
** "Header.php", We have break the template into header.php and footer.php in order to remove 
** redundancy. This is actually main header.php file where we have loaded the style sheet,
** javascript, html classes and ids. 
***
-->
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title></title>
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <link rel="stylesheet" type="text/css" href="style.css">
      <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
   </head>
   <body>
      <!------ Include the above in your HEAD tag ---------->
      <div id="throbber" style="display:none; min-height:120px;"></div>
      <div id="noty-holder"></div>
      <div id="wrapper">
         <!-- Navigation -->
         <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin User <b class="fa fa-angle-down"></b></a>
                  <ul class="dropdown-menu">
                     <li><a href="#"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>
                  </ul>
               </li>
            </ul>
            <!-- END Top Menu Items -->


            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
               <ul class="nav navbar-nav side-nav">

                  <li>
                     <a href="http://localhost/crm/dashboard.php"><i class="fa fa-fw fa-paper-plane-o"></i> Dashboard</a>
                  </li>

                  <li>
                     <a href="http://localhost/crm"><i class="fa fa-fw fa-paper-plane-o"></i> Orders</a>
                  </li>

                  <li>
                     <a href="http://localhost/crm//hotels.php"><i class="fa fa-fw fa-paper-plane-o"></i> Hotels</a>
                  </li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
         </nav>