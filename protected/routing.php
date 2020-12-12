<?php 
if(!array_key_exists('P', $_GET) || empty($_GET['P']))
	$_GET['P'] = 'home';

	switch ($_GET['P']) {
		case 'home': require_once PROTECTED_DIR.'normal/home.php'; break;
		case 'test': require_once PROTECTED_DIR.'normal/permission_test.php'; break;



		case 'list_recipe': isUserLoggedIn() ? require_once PROTECTED_DIR.'recipes/list.php' : header('Location: index.php'); break;
		case 'add_recipe': isUserLoggedIn() ? require_once PROTECTED_DIR.'recipes/add.php' : header('Location: index.php'); break;
		case 'recipe': isUserLoggedIn() ? require_once PROTECTED_DIR.'recipes/recipe.php' : header('Location: index.php'); break;
		case 'edit_recipe': isUserLoggedIn() ? require_once PROTECTED_DIR.'recipes/edit.php' : header('Location: index.php'); break;


		case 'bug_report': isUserLoggedIn() ? require_once PROTECTED_DIR.'normal/bug.php' : header('Location: index.php'); break;



		case 'login': !isUserLoggedIn() ? require_once PROTECTED_DIR.'user/login.php' : header('Location: index.php'); break;
		case 'register': !isUserLoggedIn() ? require_once PROTECTED_DIR.'user/register.php' : header('Location: index.php'); break;
		case 'logout': isUserLoggedIn() ? UserLogout() : header('Location: index.php'); break;


		case 'users': isUserLoggedIn() ? require_once PROTECTED_DIR.'user/user_list.php' : header('Location: inndex.php'); break;
		case 'edit_user': isUserLoggedIn() ? require_once PROTECTED_DIR.'user/edit_user.php' : header('Location: index.php'); break;

		default: require_once PROTECTED_DIR.'normal/404.php'; break;
	}

?>