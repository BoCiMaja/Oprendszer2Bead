<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 2) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>

	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editUser'])){
			$postData = [
				'id' => $_POST['id'],
				'first_name' => $_POST['first_name'],
				'last_name' => $_POST['last_name'],
				'email' => $_POST['email'],
				'permission' => $_POST['permission']
			];

			if(empty($postData['first_name']) || empty($postData['last_name']) || empty($postData['email'])){
				echo "Missing data(s)";
			} else if(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)){
				echo "Invalid email fomrat!";
			} else if($postData['permission'] != $_SESSION['permission'] && $_SESSION['id'] == $postData['id']){
				echo "You can't edit you own permission!";
			} else {
				$query = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, permission = :permission WHERE id = :id";
				$params = [
					':id' => $postData['id'],
					':first_name' => $postData['first_name'],
					':last_name' => $postData['last_name'],
					':email' => $postData['email'],
					':permission' => $postData['permission']
				];
				require_once DATABASE_CONTROLLER;
				if(!executeDML($query, $params)) {
					echo "Hiba az adatbevitel során!";
				} header('Location: index.php');
			}
		}
		$query2 = "SELECT id, first_name, last_name, email, permission FROM users WHERE id = :id ";
		$params2 = [':id' => $_GET['e']];
		require_once DATABASE_CONTROLLER;
		$users = getList($query2, $params2);
	?>

	<?php foreach ($users as $u) : ?>
		<form method="post">
			<input type="hidden" name = "id" value="<?=$u['id']?>">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="userFirstName">First Name</label>
					<input type="text" class="form-control" id="userFirstName" name="first_name" value = "<?=$u['first_name']?>">
				</div>
				<div class="form-group col-md-6">
					<label for="userLastName">Last Name</label>
					<input type="text" class="form-control" id="userLastName" name="last_name" value = "<?=$u['last_name']?>">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="userEmail">Email</label>
					<input type="email" class="form-control" id="userEmail" name="email" value = "<?=$u['email']?>">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-12">
			    	<label for="workerPermission">Permission</label>
			    	<select class="form-control" id="userPermission" name="permission" value = "<?=$u['permission']?>">
			      		<?php if ($u['permission'] == 0): ?>
			    			<option value="0" selected>Check</option>
			      			<option value="1">Add</option>
			      			<option value="2">Admin</option>
			      		<?php elseif ($u['permission'] == 1): ?>
			      			<option value="0">Check</option>
			      			<option value="1" selected>Add</option>
			      			<option value="2">Admin</option>
			      		<?php elseif ($u['permission'] == 2): ?>
			      			<option value="0">Check</option>
			      			<option value="1">Add</option>
			      			<option value="2" selected>Admin</option>
			    		<?php endif ?>
			    	</select>
			  	</div>
			</div>

			<button type="submit" class="btn btn-primary" name="editUser">Save</button>
		</form>
	<?php endforeach; ?>
<?php endif; ?>