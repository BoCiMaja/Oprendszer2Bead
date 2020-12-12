<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 2) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>

	<?php 
		if(array_key_exists('d', $_GET) && !empty($_GET['d'])) {
			$query = "DELETE FROM users WHERE id = :id";
			$params = [':id' => $_GET['d']];
			require_once DATABASE_CONTROLLER;
			if($_GET['d'] == $_SESSION['uid']){
				echo "You can't delete yourself in here!";
			} else if($_SESSION['permission'] < 3){
				echo "Access is forbidden";
			} else if(!executeDML($query, $params)) {
				echo "Error during deleting user!";
			}
		}
	?>

	<?php 
		$query = "SELECT id, first_name, last_name, email, permission FROM users";
		require_once DATABASE_CONTROLLER;
		$users = getList($query);
	?>

	<?php if(count($users) <= 0) : ?>
		<h1>No users found in the database.</h1>
	<?php else : ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">First Name</th>
					<th scope="col">Last Name</th>
					<th scope="col">Email</th>
					<th scope="col">Permission</th>
					<th scope="col">Edit</th>
					<th scope="col">Delete</th>
				<tr>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($users as $u) : ?>
					<?php $i++; ?>
					<tr>
						<th scope="row"><?=$i ?></th>
						<td><?=$u['first_name'] ?></td>
						<td><?=$u['last_name'] ?></td>
						<td><?=$u['email'] ?></td>
						<td><?=$u['permission'] ?></td>
						<td><a href="<?='index.php?P=edit_user&e='.$u['id']?>">Edit</a></td>
						<td><a href="?P=users&d=<?=$u['id'] ?>">Delete</a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
<?php endif; ?>