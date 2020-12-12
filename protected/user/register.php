<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
  $postData = [
      'fname' => $_POST['first_name'],
      'lname' => $_POST['last_name'],
      'email' => $_POST['email'],
      'email1' => $_POST['email1'],
      'password' => $_POST['password'],
      'password1' => $_POST['password1']
  ];

  if(empty($postData['fname']) || empty($postData['lname']) || empty($postData['email']) || empty($postData['email1']) || empty($postData['password']) || empty($postData['password1'])) {
    echo "Missing data(s)!";
  } else if($postData['email'] != $postData['email1']) {
    echo "Email adresses must match!";
  } else if(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)){
    echo "Invalid email format!";
  } else if($postData['password'] != $postData['password1']){
    echo "Passwords must match!";
  } else if(strlen($postData['password']) < 6) {
    echo "The password is too short! The password needs to be at least 6 characters.";
  } else if(!UserRegister($postData['email'], $postData['password'], $postData['fname'], $postData['lname'])) {
    echo "Registration failed!";
  }

  $postData['password'] = $postData['password1'] = "";
}
?>

<form method="post">
	<div class="form-row">
    <div class="form-group col-md-6">
      <label for="registerFirstName">First Name</label>
      <input type="text" class="form-control" id="registerFirstName" name="first_name" value = "<?=isset($postData) ? $postData['fname'] : "";?>">
    </div>
    <div class="form-group col-md-6">
      <label for="registerLastName">Last Name</label>
      <input type="text" class="form-control" id="registerLastName" name="last_name" value = "<?=isset($postData) ? $postData['lname'] : "";?>">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="registerEmail">Email</label>
      <input type="email" class="form-control" id="registerEmail" name="email" value = "<?=isset($postData) ? $postData['email'] : "";?>">
    </div>
    <div class="form-group col-md-6">
      <label for="registerEmail1">Confirm Email</label>
      <input type="email" class="form-control" id="registerEmail1" name="email1" value = "<?=isset($postData) ? $postData['email1'] : "";?>">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="registerPassword">Password</label>
      <input type="password" class="form-control" id="registerPassword" name="password" value= "">
    </div>
    <div class="form-group col-md-6">
      <label for="registerPassword1">Confirm Password</label>
      <input type="password" class="form-control" id="registerPassword1" name="password1" value="">
    </div>
  </div>

  <button type="submit" class="btn btn-primary" name="register">Register</button>
</form>