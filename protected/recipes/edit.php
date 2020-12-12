<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] <= 1) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>

	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editRecipe'])){
			$postData = [
				'id' => $_POST['id'],
				'dish_name' => $_POST['dish_name'],
				'difficulty' => $_POST['difficulty'],
				'category' => $_POST['category'],
				'calorie' => $_POST['calorie'],
				'ingredients' => $_POST['ingredients'],
				'directions' => $_POST['directions'],
				'description' => $_POST['description']
			];

			if(empty($postData['dish_name']) || empty($postData['difficulty']) || empty($postData['category']) || empty($postData['calorie']) || empty($postData['ingredients']) || empty($postData['directions']) || empty($postData['description'])){
				echo "Missing data(s)";
			} else {
				$query = "UPDATE recipes SET dish_name = :dish_name, difficulty = :difficulty, category = :category, calorie = :calorie, ingredients = :ingredients, directions = :directions, description = :description WHERE id = :id";
				$params = [
					':id' => $postData['id'],
					':dish_name' => $postData['dish_name'],
					':difficulty' => $postData['difficulty'],
					':category' => $postData['category'],
					':calorie' => $postData['calorie'],
					':ingredients' => $postData['ingredients'],
					':directions' => $postData['directions'],
					':description' => $postData['description']
				];
				require_once DATABASE_CONTROLLER;
				if(!executeDML($query, $params)) {
					echo "Hiba az adatbevitel során!";
				} header('Location: index.php');
			}
		}
		$query2 = "SELECT id, dish_name, difficulty, category, calorie, ingredients, directions, description FROM recipes WHERE id = :id ";
		$params2 = [':id' => $_GET['e']];
		require_once DATABASE_CONTROLLER;
		$recipes = getList($query2, $params2);
	?>

	<?php foreach ($recipes as $r) : ?>
		<form method="post">
			<input type="hidden" name = "id" value="<?=$r['id']?>">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="recipeDishName">Dish Name</label>
					<input type="text" class="form-control" id="recipeDishName" name="dish_name" value = "<?=$r['dish_name']?>">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="recipeDescription">Description</label>
					<textarea type="text" placeholder="Please say something about it!" class="form-control" id="recipeDescription" name="description" rows="3"><?=$r['description']?></textarea>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
			    	<label for="recipeDifficulty">Difficulty</label>
			    	<?php
						$select = array("There is nothing here", "Very Easy", "Easy", "Medium", "Hard", "Very Hard");
						$fromwhere = $r['difficulty']
					?>

			    	<select class="form-control" id="recipeDifficulty" name="difficulty">
			    		<<option value="0">There is nothing here</option>
						<?php for ($i=1; $i < $fromwhere; $i++):?>
							<option value="<?=$select[$i]?>"><?=$select[$i]?></option>
			      		<?php endfor; ?>
			      		<option value="<?=$select[$fromwhere]?>" selected><?=$select[$fromwhere]?></option>
			      		<?php for ($i=$fromwhere; $i < count($select); $i++):?>
							<option value="<?=$select[$i]?>"><?=$select[$i]?></option>
			      		<?php endfor; ?>
			      		
			    	</select>
			  	</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="recipeCategory">Category</label>
					<?php
						$fromwhere = 0;
						$select = array("There is nothing here", "Breakfast", "Soup", "Main Course", "Dessert", "Salad", "Drinks", "Dinner", "Garnish");
					?>
					<?php switch($r['category']){
							case "Breakfast": $fromwhere = 1; break;
							case "Soup": $fromwhere = 2; break;
							case "Main Course": $fromwhere = 3; break;
							case "Dessert": $fromwhere = 4; break;
							case "Salad": $fromwhere = 5; break;
							case "Drinks": $fromwhere = 6; break;
							case "Dinner": $fromwhere = 7; break;
							case "Garnish": $fromwhere = 8; break;
							default: $fromwhere = 0; break;
					} ?>

					<select class="form-control" id="recipeCategory" name="category">
						<option value="0">There is nothing here</option>
						<?php for ($i=1; $i < $fromwhere; $i++):?>
							<option value="<?=$select[$i]?>"><?=$select[$i]?></option>
			      		<?php endfor; ?>
			      		<option value="<?=$select[$fromwhere]?>" selected><?=$select[$fromwhere]?></option>
			      		<?php for ($i=$fromwhere; $i < count($select); $i++):?>
							<option value="<?=$select[$i]?>"><?=$select[$i]?></option>
			      		<?php endfor; ?>
			    	</select>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="recipeCalorie">Calorie</label>
					<input type="text" class="form-control" id="recipeCalorie" name="calorie"  value = "<?=$r['calorie']?>">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="recipeIngredients">Ingredients</label>
					<textarea type="text" placeholder="Please write the ingredients here! Please split the lines with ENTER!" class="form-control" id="recipeIngredients" name="ingredients" rows="8"><?=$r['ingredients']?></textarea>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="recipeDirections">Directions</label>
					<textarea type="text" placeholder="Please write the instuctions here! Please split the lines with ENTER!" class="form-control" id="recipeDirections" name="directions" rows="10"><?=$r['directions']?></textarea>
				</div>
			</div>

			<button type="submit" class="btn btn-primary" name="addRecipe">Add Recipe</button>
		</form>
	<?php endforeach; ?>
<?php endif; ?>