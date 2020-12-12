<?php if(!isset($_SESSION['permission'])): ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>

	<?php 
		if(array_key_exists('d', $_GET) && !empty($_GET['d'])) {
			$query = "DELETE FROM recipes WHERE id = :id";
			$params = [':id' => $_GET['d']];
			require_once DATABASE_CONTROLLER;
			if($_SESSION['permission'] < 3){
				echo "Access is forbidden";
			} else if(!executeDML($query, $params)) {
				echo "Error during deleting recipe!";
			}
		}
	?>

	<?php

		if(array_key_exists('c', $_GET) && !empty($_GET['c'])){
			$category = $_GET['c'];

			if(isset($_POST['submit']) && $_POST['word'] !== ' ' && !(empty($_POST['word']))){
				$search = $_POST['word'];

				$query = "SELECT id, dish_name, difficulty, category, calorie FROM recipes WHERE (dish_name LIKE '%$search%' AND category = '$category')";
				require_once DATABASE_CONTROLLER;
				$recipes = getList($query);
			}
			else
			{
				$query = "SELECT id, dish_name, difficulty, category, calorie FROM recipes WHERE category = '$category'";
				require_once DATABASE_CONTROLLER;
				$recipes = getList($query);
			}
		}
		elseif(isset($_POST['submit']) && $_POST['word'] !== ' ' && !(empty($_POST['word']))){
			$search = $_POST['word'];
		
			$query = "SELECT id, dish_name, difficulty, category, calorie FROM recipes WHERE dish_name LIKE '%$search%'";
			require_once DATABASE_CONTROLLER;
			$recipes = getList($query);
		}
		else
		{
			$query = "SELECT id, dish_name, difficulty, category, calorie FROM recipes ORDER BY dish_name ASC";
			require_once DATABASE_CONTROLLER;
			$recipes = getList($query);
		}
	?>



	<table class="table table-striped">
		<tbody>
			<tr>
				<th><a href="?P=list_recipe&c=Breakfast"><img border="0" alt="Breakfast" src="Breakfast.jpg"></a></th>
				<th><a href="?P=list_recipe&c=Soup"><img border="0" alt="Soup" src="Soup.jpg"></a></th>
				<th><a href="?P=list_recipe&c=Main Course"><img border="0" alt="Main Course" src="Main course2.jpg"></a></th>
				<th><a href="?P=list_recipe&c=Dessert"><img border="0" alt="Dessert" src="Dessert.jpg"></a></th>
			</tr>
			<tr>
				<th><a href="?P=list_recipe&c=Salad"><img border="0" alt="Salad" src="Salad.jpg"></a></th>
				<th><a href="?P=list_recipe&c=Drinks"><img border="0" alt="Drinks" src="Drinks.jpg"></a></th>
				<th><a href="?P=list_recipe&c=Dinner"><img border="0" alt="Dinner" src="Dinner.jpg"></a></th>
				<th><a href="?P=list_recipe&c=Garnish"><img border="0" alt="Garnish" src="Garnish.jpg"></a></th>
			</tr>
		</tbody>
	</table>
	
	<form method="post" style="text-align: center">
		<input type="text" name='word'>
		<input type="submit" value="Search" name="submit">
	</form>
	<hr style="width: 75%">


	<?php if(count($recipes) <= 0) : ?>
		<h1>No recipes found in the database.</h1>
	<?php else : ?>

		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col" width=10%>#</th>
					<th scope="col">Dish name</th>
					<th scope="col" width=15%>Difficulty</th>
					<th scope="col" width=20%>Category</th>
					<th scope="col" width=15%>Calorie</th>
					<?php if($_SESSION['permission'] >= 2) : ?>
						<th scope="col" width=10%>Szerkesztés</th>
						<?php if($_SESSION['permission'] >=3) : ?>
							<th scope="col" width=10%>Törlés</th>
						<?php endif; ?>
					<?php endif; ?>
				<tr>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($recipes as $r) : ?>
					<?php $i++; ?>
					<tr>
						<th scope="row"><?=$i ?></th>
						<td><a href="<?='index.php?P=recipe&id='.$r['id']?>"><?=$r['dish_name'] ?></a></td>
						<td><?= $r['difficulty'] == 1 ? 'Very Easy' : ($r['difficulty'] == 2 ? 'Easy' : ($r['difficulty'] == 3 ? 'Medium' : ($r['difficulty'] == 4 ? 'Hard' : 'Very Hard')));?></td>
						<td><?=$r['category'] ?></td>
						<td><?=$r['calorie'] ?></td>
						<?php if($_SESSION['permission'] >= 2) : ?>
							<td><a href="<?='index.php?P=edit_recipe&e='.$r['id']?>">Edit</a></td>
							<?php if($_SESSION['permission'] >=3) : ?>
								<td><a href="?P=list_recipe&d=<?=$r['id'] ?>">Delete</a></td>
							<?php endif; ?>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
<?php endif; ?>