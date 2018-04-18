<?php

require_once 'classes/Database.php';
require_once 'classes/ListItem.php';
require_once 'classes/Person.php';
require_once 'classes/Group.php';

include 'includes/header.php';

?>
  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">Breeze Test</h5>
    </div>

   <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Add or Update Groups and People</h1>
          <p class="lead text-muted">Click any of the buttons to add People or Groups to your database</p>
          <p>
            <a href="#" class="btn btn-primary my-2" id="add-group">Add Groups</a>
            <a href="#" class="btn btn-secondary my-2" id="add-people">Add People</a>
          </p>
        </div>
    </section>

    <div class="container">
      <section class="table-data">
      	<div class="user-data">
      		<?php include 'user_data.php'; ?>
      	</div>
      </section>

    <?php
		include 'includes/footer.php';
	?>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">

    	var addGroup = new Dropzone("a#add-group", { 
    		url: "/file.php?type=groups",
    		acceptedFiles: 'text/csv',
    		paramName: 'uploadFile',
    		success: function (file, response) {
   				this.removeFile(file);
   				$('.user-data').html(response)
			}	
    	});

    	var addPeople = new Dropzone("a#add-people", { 
    		url: "/file.php?type=people",
    		acceptedFiles: 'text/csv',
    		paramName: 'uploadFile',
    		success: function (file, response) {
   				this.removeFile(file);
   				$('.user-data').html(response)
			 }
    	});

    </script>
  </body>
</html>



