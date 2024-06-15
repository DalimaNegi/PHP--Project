<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber_Crime Form</title>
    <link rel="stylesheet" href="registration.css">
</head>

<body>
<?php
// all required variables defined here and set to empty values
$nameError = $emailError = $locationError= $genderError = "";
$name = $email = $location = $gender="";

$submissionSuccess = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameError = "Name is mandatory";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameError = "Only letters are allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailError = "Email is mandatory";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailError = "Invalid email format";
    }
  }

  if (empty($_POST["location"])) {
    $locationError = "Location is necessary";
  }
  else{
    $location = test_input($_POST["location"]);
  }

  if (empty($_POST["gender"])) {
    $genderError = "Gender is required";
  }
  else{
    $gender = test_input($_POST["gender"]);
  }

}

if(isset($_POST["submit"])) {
  $name = $_POST['name'];
  $age = $_POST["age"];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
  $phone = $_POST['phone'];
  $incidentType = $_POST["incidentType"];
  $description = $_POST['description'];
  $location = $_POST['location'];
  $additionalInfo = $_POST['additionalInfo'];
//Creating connection with the database
if(empty($nameError) && empty($emailError) && empty($locationError) && empty($genderError)){
$servername="localhost";
$username = "root";
$password = "";
$dbname = "formdb";

$conn = mysqli_connect($servername,$username,$password,$dbname);
if(!$conn){
  die("Connection Failed :".mysqli_connect_error());
}
$sql = "INSERT INTO crime_data(name,age,email,gender,phone,incidentType,description,location,additionalInfo) VALUES('$name','$age','$email','$gender','$phone','$incidentType','$description','$location','$additionalInfo')";

mysqli_query($conn,$sql);
// Set submission success flag to true
$submissionSuccess = true;
}
}

if($submissionSuccess){
  header("Location: success_page.php");
  exit();
}

function test_input($data) {
  $data = trim($data);   
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

    <!-- Creating a form -->
    <form class="crime-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

<h2 class="form-title">Cyber Crime Reporting Form</h2>

<label for="name" class="form-label">Name:</label>
<input type="text" name="name" id="name" class="form-input">
<span class="error-color form-error">
    <?php echo isset($nameError) ? $nameError: ''; ?></span> <br>

<label for="age" class="form-label">Age:</label>
<input type="number" name="age" id="age" class="form-input" required> <br><br>

<label for="email" class="form-label">E-mail:</label>
<input type="text" name="email" id="email" class="form-input">
<span class="error-color form-error">
    <?php echo isset($emailError) ? $emailError: ''; ?>
</span> <br> 

<label class="form-label">Gender:</label>
<input type="radio" name="gender" value="Male" id="maleGender">Male 
<input type="radio" name="gender" value="Female" id="femaleGender">Female 
<input type="radio" name="gender" value="Other" id="otherGender">Other
<span class="error-color form-error">
    <?php echo isset($genderError) ? $genderError:''; ?>
</span> <br> 

<label for="phone" class="form-label">Phone Number:</label>
<input type="tel" id="phone" name="phone" class="form-input" required> <br><br>

<label for="incidentType" class="form-label">Incident Type:</label>
<select id="incidentType" name="incidentType" class="form-input" required>
    <option value="incidentType">Phishing</option>
    <option value="incidentType">Hacking</option>
    <option value="incidentType">Identity Theft</option>
    <option value="incidentType">Data Breach</option>
    <option value="incidentType">Cyber-Bullying</option>
</select> <br><br>

<label for="description" class="form-label">Description of Incident:</label>
<textarea id="description" name="description" class="form-input" rows="4" required></textarea><br><br>

<label for="location" class="form-label">Location of Incident:</label>
<input type="text" id="location" name="location" class="form-input" required><br><br>

<label for="additionalInfo" class="form-label">Evidence(if any):</label>
<textarea id="additionalInfo" name="additionalInfo" class="form-input" rows="4"></textarea><br><br>

<label for="checkinfo" class="form-checkbox-label">
    <input type="checkbox" name="checkinfo" id="checkinfo" class="form-checkbox" required>
    I confirm that the information provided in this report is accurate to the best of my knowledge.
</label><br><br>

<button type="submit" class="form-submit" name="submit">Submit Form</button>
</form>
</body>

</html>