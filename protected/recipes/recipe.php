<?php if(!isset($_SESSION['permission'])) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>
	<?php 
		$query = "SELECT id, dish_name, difficulty, category, calorie, ingredients, directions, description FROM recipes WHERE id = :id";
		require_once DATABASE_CONTROLLER;
		$params = [':id' => $_GET['id']];
		$recipes = getList($query, $params);
	?>

	<?php foreach ($recipes as $r) : ?>
		<h1> <?=$r['dish_name']?></h1>
		<h5><?=$r['category']?></h5>
		<?=$r['description']?> <br>
		<?= $r['difficulty'] == 1 ? 'Very Easy' : ($r['difficulty'] == 2 ? 'Easy' : ($r['difficulty'] == 3 ? 'Medium' : ($r['difficulty'] == 4 ? 'Hard' : 'Very Hard')));?> | <?=$r['calorie']?> kcal
		<hr style="width: 75%">
		<h4>Ingredients</h4>
		<pre><?=$r['ingredients']?></pre>
		<hr style="width: 75%">
		<h4>Direction</h4>
		<pre><?=$r['directions']?></pre>
	<?php endforeach; ?>

<?php endif; ?>