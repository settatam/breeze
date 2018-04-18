<?php

require_once 'classes/Database.php';
require_once 'classes/ListItem.php';
require_once 'classes/Person.php';
require_once 'classes/Group.php';

//Get all the active persons
$persons = Person::getAllActive();



if(count($persons) < 1) { ?>

<div> You have no active users. Please upload your cvs to upload files. </div>
	
<? } else { ?>

<table class="table" id="sortable">
  <thead>
    <tr>
      <th scope="col">Person ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email Address</th>
      <th scope="col">Group ID</th>
      <th scope="col">State</th>
    </tr>
  </thead>
  <tbody>

  <?php
  foreach($persons as $person) { ?>
  	<tr>
      <th scope="row"> <?=$person['person_id'] ?></th>
      <td> <?=$person['first_name'] ?></td>
      <td> <?=$person['last_name'] ?> </td>
      <td> <?=$person['email_address'] ?></td>
      <td> <?=$person['group_name'] ?></td>
      <td> <?=$person['state'] ?></td>
    </tr>
  
  <? } } ?>
</tbody>
       
</table>

<script type="text/javascript">

      $( function() {
        $( "tbody" ).sortable();
      });
  </script>

