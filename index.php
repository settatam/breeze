<?php

require_once 'classes/Database.php';
require_once 'classes/ListItem.php';
require_once 'classes/Person.php';
require_once 'classes/Group.php';

include 'includes/header.php';

// Rest of the page comes here

// $person = ['first_name'=>'seth', 'last_name'=>'atam', 'email_address'=>'seth@mg.com', 'group_id'=>'3', 'state'=>'active'];
// $person = new Person($person);
// $person->Add();
?>
  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">Breeze Test</h5>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Church Membership</h1>

      <!-- Church group table and membership will be displayed here -->
     
    </div>

    <div class="container">
      

    <?php
		include 'includes/footer.php';
	?>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>



