<h1>Bug report</h1>
<?php 
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['report'])){
	  $postData = [
	      'description' => $_POST['description'],
	      'email' => $_POST['email']
	  ];

	  if(empty($postData['description'])) {
	    echo "Missing description!";
	  } else if(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL) && !empty($postData['email'])){
	    echo "Hibás email formátum!";
	  } else
	  {
	  	$query = "INSERT INTO bugs (email, description) VALUES (:email, :description)";
		$params = [
			':email' => $postData['email'],
			':description' => $postData['description']
		];
		require_once DATABASE_CONTROLLER;
		if(!executeDML($query, $params)) {
			echo "Hiba az adatbevitel során!";
		} header('Location: index.php');
	  }
	}
?>

<form method="post">
    <div class="form-row">
    	<div class="form-group col-md-6">
      	<label for="reporterEmail">Email</label>
      	<input type="email" class="form-control" id="reporterEmail" name="email" value = "<?=isset($postData) ? $postData['email'] : "";?>" placeholder="You don't have to give your email address">
    	</div>
    </div>

    <div class="form-row">
			<div class="form-group col-md-6">
				<label for="bugDescription">Description</label>
				<textarea type="text" placeholder="Please describe the problem!" class="form-control" id="bugDescription" name="description" rows="3" value = "<?=isset($postData) ? $postData['description'] : "";?>"></textarea>
			</div>
		</div>

  <button type="submit" class="btn btn-primary" name="report">Report</button>
</form>