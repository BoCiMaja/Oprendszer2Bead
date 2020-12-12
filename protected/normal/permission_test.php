<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 1) : ?>
	<h1>Page access is forbidden!</h1>
	Permission check: <?=isset($_SESSION['permission']) ? $_SESSION['permission'] : "You don't have a permission!" ?>
<?php else : ?>
	<h1>Access allowed</h1>
	<p>Your permission level is <?=$_SESSION['permission'] ?></p>
	<?php switch ($_SESSION['permission']) {
		case '0':
			echo "You can search between recipes.";
			break;
		case '1':
			echo "You can search between and add new recipes.";
			break;
		case '2':
			echo "You can search between, add new and edit the recipes.";
			break;
		default:
			echo "You can search between, add new and edit the recipes. Also you can edit and remove the data of the users.";
			break;
	} ?>
<?php endif; ?>