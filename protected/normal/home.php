<h1>Recently added recipes</h1>
<?php 
	$query = "SELECT id, dish_name, category, description FROM recipes";
	require_once DATABASE_CONTROLLER;
	$recipes = getList($query);
?>

<?php if(count($recipes) <= 0) : ?>
	<h1>No recipes found in the database.</h1>
<?php else : ?>
	<?php $db = count($recipes); ?>
	<?php if($db >= 5) : ?>
		<?php for ($i = $db - 1; $i > $db - 6 ; $i--) : ?>
			<hr style="width: 75%">

			<?php
				switch($recipes[$i]['category']){
					case "Breakfast": $category = "Breakfast.jpg"; break;
					case "Soup": $category = "Soup.jpg"; break;
					case "Main Course": $category = "Main Course.jpg"; break;
					case "Dessert": $category = "Dessert.jpg"; break;
					case "Salad": $category = "Salad.jpg"; break;
					case "Drinks": $category = "Drinks.jpg"; break;
					case "Dinner": $category = "Dinner.jpg"; break;
					case "Garnish": $category = "Garnish.jpg"; break;
					default: $category = "Breakfast.jpg"; break;
				}
			?>

			<div id = "floated">
				<a href="<?='index.php?P=recipe&id='.$recipes[$i]['id']?>"><img border="0" alt="Breakfast" src="<?=$category?>" width=100px class="floatleft" style="float: left; margin-right: 20px;"></a>
			</div>
			
			<h3><?=$recipes[$i]['dish_name'] ?></h3>
			<?=$recipes[$i]['category'] ?> <br>
			<?=$recipes[$i]['description'] ?>
		<?php endfor; ?>

	<?php else : ?>
		<?php for ($i = $db - 1; $i >= 0 ; $i--) : ?>
			<hr style="width: 75%">

			<?php
				switch($recipes[$i]['category']){
					case "Breakfast": $category = "Breakfast.jpg"; break;
					case "Soup": $category = "Soup.jpg"; break;
					case "Main Course": $category = "Main Course.jpg"; break;
					case "Dessert": $category = "Dessert.jpg"; break;
					case "Salad": $category = "Salad.jpg"; break;
					case "Drinks": $category = "Drinks.jpg"; break;
					case "Dinner": $category = "Dinner.jpg"; break;
					case "Garnish": $category = "Garnish.jpg"; break;
					default: $category = "Breakfast.jpg"; break;
				}
			?>

			<div id = "floated">
				<a href="<?='index.php?P=recipe&id='.$recipes[$i]['id']?>"><img border="0" alt="Breakfast" src="<?=$category?>" width=100px class="floatleft" style="float: left; margin-right: 20px;"></a>
			</div>
			
			<h3><?=$recipes[$i]['dish_name'] ?></h3>
			<?=$recipes[$i]['category'] ?> <br>
			<?=$recipes[$i]['description'] ?>
		<?php endfor; ?>
	<?php endif; ?>

<?php endif; ?>