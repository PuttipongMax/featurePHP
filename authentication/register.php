<?php
 include "layout/header.php";

 $first_name = "";
 $last_name = "";
 $email = "";
 $phone = "";
 $address = "";
 $password = "";
 $confirm_password = "";

 $first_name_error = "";
 $last_name_error = "";
 $email_error = "";
 $phone_error = "";
 $address_error = "";
 $password_error = "";
 $confirm_password_error = "";

 $error = false;

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
 }

 /************ validate first_name ************/
 if(empty($first_name)){
  $first_name_error = "First name is required";
  $error = true;
 }

 /************ validate last_name ************/
 if(empty($last_name)){
  $last_name_error = "Last name is required";
  $error = true;
 }

 /************ validate email ************/
 // check email format
 if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  $email_error = "Email format is not valid";
  $error = true;
 }

 include "tools/db.php";
 $dbConnection = getDatabaseConnection();
 $statement = $dbConnection->prepare("SELECT id FROM users WHERE email = ?");

 // Bind variables to the prepared statement as parameters
 $statement->bind_param("s", $email);

 // execute statement
 $statement->execute();

 // check if email is already in the database
 $statement->store_result();
 if($statement->num_rows > 0){
  $email_error = "Email is already used.";
  $error = true;
 }

 // close this statement otherwise we cannot prepare another statement
 $statement->close();

 /************ validate phone ************/ 
 // Define a regex for phone format
 // Optional country code (+ or 00 followed by 1 to 3 digits)
 // Optional space or dash separator
 // Number (7 to 12 digits)
 if(!preg_match("/^(\+|00\d{1,3})?[- ]?\d{7,12}$/", $phone)){
  $phone_error = "Phone format is not valid";
  $error = true;
 }

 /************ validate password ************/ 
 if(strlen($password) < 6){
  $password_error = "Password must have at least 6 characters";
  $error = true;
 }

 /************ validate confirm_password ************/ 
 if($confirm_password != $password){
  $confirm_password_error = "Password and Confirm Password do not match";
  $error = true;
 }

 if(!$error){
  /************ All fields are valid: create a new user ************/
  $password = password_hash($password, PASSWORD_DEFAULT);
  $created_at = date('Y-m-d H:i:s');

  // let use prepared statements to avoid "sql injection attacks"
  $statement = $dbConnection->prepare(
   "INSERT INTO users (first_name, last_name, email, phone, address, password, created_at) ".
    "VALUES (?, ?, ?, ?, ?, ?, ?)"
  );

  // Bind variables to the prepared statement as parameters
  $statement->bind_param('sssssss', $first_name, $last_name, $email, $phone, $address, $password, $created_at);

  // execute statement
  $statement->execute();

  $insert_id = $statement->insert_id;
  $statement->close();

  /************ A new account is created ************/
  // Save session data
  $_SESSION["id"] = $insert_id;
  $_SESSION["first_name"] = $first_name;
  $_SESSION['last_name'] = $last_name;
  $_SESSION['email'] = $email;
  $_SESSION['phone'] = $phone;
  $_SESSION['address'] = $address;
  $_SESSION['created_at'] = $created_at;

  // Redirect user to the home page
  header("location: ". $base_url. "/index.php");
  exit();
 }

?>

<div class="container py-5">
 <div class="row ">
  <div class="col-lg-6 mx-auto border shadow p-4">
   <h2 class="text-center mb-4">Register</h2>
   <hr />

   <form method="post">
    <div class="row">
     <label class="col-sm-4 col-form-label ">First Name*</label>
     <div class="col-sm-8">
      <input class="form-control" name="first_name" 
       value="<?php echo $first_name; ?>" />
      <span class="text-danger"><?php echo $first_name_error ?></span>
     </div>
    <div>

    <div class="row ">
     <label class="col-sm-4 col-form-label mt-3">Last Name*</label>
     <div class="col-sm-8">
      <input class="form-control mt-3" name="last_name" 
       value="<?php echo $last_name; ?>" />
      <span class="text-danger"><?php echo $last_name_error; ?></span>
     </div>
    <div>

    <div class="row">
     <label class="col-sm-4 col-form-label mt-3">Email*</label>
     <div class="col-sm-8">
      <input class="form-control mt-3" name="email" 
       value="<?php echo $email; ?>" />
      <span class="text-danger"><?php echo $email_error; ?></span>
     </div>
    <div>

    <div class="row ">
     <label class="col-sm-4 col-form-label mt-3">phone*</label>
     <div class="col-sm-8">
      <input class="form-control mt-3" name="phone" 
       value="<?php echo $phone; ?>" />
      <span class="text-danger"><?php echo $phone_error; ?></span>
     </div>
    <div>

    <div class="row">
     <label class="col-sm-4 col-form-label mt-3">Address</label>
     <div class="col-sm-8">
      <input class="form-control mt-3" name="address" 
       value="<?php echo $address; ?>" />
      <span class="text-danger"><?php echo $address_error; ?></span>
     </div>
    <div>

    <div class="row">
     <label class="col-sm-4 col-form-label mt-3">Password*</label>
     <div class="col-sm-8">
      <input class="form-control mt-3" type="password" name="password" value="" />
      <span class="text-danger"><?php echo $password_error; ?></span>
     </div>
    <div>

    <div class="row">
     <label class="col-sm-4 col-form-label mt-3">Confirm Password*</label>
     <div class="col-sm-8">
      <input class="form-control mt-3" type="password" name="confirm_password" value="" />
      <span class="text-danger"><?php echo $confirm_password_error; ?></span>
     </div>
    <div>

    <div class="row">
     <div class="offset-sm-4 col-sm-4 d-grid mt-3">
      <button type="submit" class="btn btn-primary">Register</button>
     </div>
     <div class="col-sm-4 d-grid mt-3">
      <a 
       href="<?php echo $base_url; ?>/index.php"
       class="btn btn-outline-primary "
      >
       Cancel
      </a>
     </div>
    <div>

   </form>
  </div>
 </div>
</div>

<?php
 include "layout/footer.php";
?>