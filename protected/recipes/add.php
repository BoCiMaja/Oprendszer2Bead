<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 1) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>
	<?php

		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addRecipe'])){
			$postData = [
				'dish_name' => $_POST['dish_name'],
				'difficulty' => $_POST['difficulty'],
				'category' => $_POST['category'],
				'calorie' => $_POST['calorie'],
				'ingredients' => $_POST['ingredients'],
				'directions' => $_POST['directions'],
				'description' => $_POST['description']
			];



			if(empty($postData['dish_name']) || empty($postData['difficulty']) || empty($postData['category']) || empty($postData['calorie']) || empty($postData['ingredients']) || empty($postData['directions']) || empty($postData['description'])){
				echo "Hiányzó adat(ok)";
			} else {
				$query = "INSERT INTO recipes (dish_name, difficulty, category, calorie, ingredients, directions, description) VALUES (:dish_name, :difficulty, :category, :calorie, :ingredients, :directions, :description)";
				$params = [
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
	?>



	<form method="post">
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="recipeDishName">Dish Name</label>
				<input type="text" class="form-control" id="recipeDishName" name="dish_name" value = "<?=isset($postData) ? $postData['dish_name'] : "";?>">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="recipeDescription">Description</label>
				<textarea type="text" placeholder="Please say something about it!" class="form-control" id="recipeDescription" name="description" rows="3" value = "<?=isset($postData) ? $postData['description'] : "";?>"></textarea>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
		    	<label for="recipeDifficulty">Difficulty</label>
		    	<select class="form-control" id="recipeDifficulty" name="difficulty" value = "<?=isset($postData) ? $postData['difficulty'] : "";?>">
		    		<option value="0">There is nothing here</option>
		      		<option value="1">Very easy</option>
		      		<option value="2">Easy</option>
		      		<option value="3">Medium</option>
		      		<option value="4">Hard</option>
		      		<option value="5">Very Hard</option>
		    	</select>
		  	</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="recipeCategory">Category</label>
				<select class="form-control" id="recipeCategory" name="category" value = "<?=isset($postData) ? $postData['category'] : "";?>">
					<option value="0">There is nothing here</option>
		      		<option value="Breakfast">Breakfast</option>
		      		<option value="Soup">Soup</option>
		      		<option value="Main Course">Main Course</option>
		      		<option value="Dessert">Dessert</option>
		      		<option value="Salad">Salad</option>
		      		<option value="Drinks">Drinks</option>
		      		<option value="Dinner">Dinner</option>
		      		<option value="Garnish">Garnish</option>
		    	</select>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="recipeCalorie">Calorie</label>
				<input type="text" class="form-control" id="recipeCalorie" name="calorie" value = "<?=isset($postData) ? $postData['calorie'] : "";?>">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="recipeIngredients">Ingredients</label>
				<textarea type="text" placeholder="Please write the ingredients here! Please split the lines with ENTER!" class="form-control" id="recipeIngredients" name="ingredients" rows="8" value = "<?=isset($postData) ? $postData['ingredients'] : "";?>"></textarea>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="recipeDirections">Directions</label>
				<textarea type="text" placeholder="Please write the instuctions here! Please split the lines with ENTER!" class="form-control" id="recipeDirections" name="directions" rows="10" value = "<?=isset($postData) ? $postData['directions'] : "";?>"></textarea>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="recipeImage">Kép</label>
				<input type="file" name="image">
			</div>
		</div>

		<button type="submit" class="btn btn-primary" name="addRecipe">Add Recipe</button>
	</form>
<?php endif; ?>