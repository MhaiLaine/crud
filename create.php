<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$last_name = $first_name = $middle_name = $birthday = $program = $sex = $address = $image = "";

$last_name_err = $first_name_err = $middle_name_err = $birthday_err = $program_err = $sex_err = $address_err = $image_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Last Name
    $input_lastname = trim($_POST["last_name"]);
    if (empty($input_lastname)) {
        $last_name_err = "Please enter a last name.";
    } elseif (!filter_var($input_lastname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $last_name_err = "Please enter a valid last name.";
    } else {
        $last_name = $input_lastname;
    }

    // Validate First Name
    $input_firstname = trim($_POST["first_name"]);
    if (empty($input_firstname)) {
        $first_name_err = "Please enter a first name.";
    } elseif (!filter_var($input_firstname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $first_name_err = "Please enter a valid first name.";
    } else {
        $first_name = $input_firstname;
    }

    // Validate Middle Name
        $input_middlename = trim($_POST["middle_name"]);
        if (!empty($input_middlename)) {
            if (!filter_var($input_middlename, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
                $middle_name_err = "Please enter a valid middle name.";
            } else {
                $middle_name = $input_middlename;
            }
        }

    // Validate Birthday
    $input_birthday = trim($_POST["birthday"]);
    if (empty($input_birthday)) {
        $birthday_err = "Please enter a birthday.";
    } else {
        $birthday = $input_birthday;
    }

    // Validate program
    $input_program = trim($_POST["program"]);
    if (empty($input_program)) {
        $program_err = "Please enter a program.";
    } else {
        $program = $input_program;
    }

    // Validate Sex
    $input_sex = trim($_POST["sex"]);
    if (empty($input_sex)) {
        $sex_err = "Please enter a valid sex.";
    } else {
        $sex = $input_sex;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    // Validate image
    $input_image = trim($_POST["image"]);
    if (empty($input_image)) {
        $image_err = "Please enter an image.";
    } else {
        $image = $input_image;
    }

    // Check input errors before inserting in database
    if (empty($last_name_err) && empty($first_name_err) && empty($middle_name_err) && empty($birthday_err) && empty($program_err) && empty($sex_err) && empty($address_err) && empty($image_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO student (last_name, first_name, middle_name, birthday, program, sex, address, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssss", $param_last_name, $param_first_name, $param_middle_name, $param_birthday, $param_program, $param_sex, $param_address, $param_image);

            // Set parameters
            $param_last_name = $last_name;
            $param_first_name = $first_name;
            $param_middle_name = $middle_name;
            $param_birthday = $birthday;
            $param_program = $program;
            $param_sex = $sex;
            $param_address = $address;
            $param_image = $image;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                        <span class="invalid-feedback"><?php echo $last_name_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                        <span class="invalid-feedback"><?php echo $first_name_err; ?></span>
                    </div>

                    <!-- not required -->
                    <div class="form-group"> 
                        <label>Middle Name</label>
                        <input type="text" name="middle_name" class="form-control" value="<?php echo $middle_name; ?>">
                        <span class="invalid-feedback"><?php echo $middle_name_err; ?></span>
                    </div>  

                        <div class="form-group">
                            <label>Birthday</label>
                            <input type="date" name="birthday" class="form-control <?php echo (!empty($birthday_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $birthday; ?>">
                            <span class="invalid-feedback"><?php echo $birthday_err; ?></span>
                        </div>

                    <!--combo button-->
                    <div class="form-group">
                        <label>Program</label>
                        <select name="program" class="form-control <?php echo (!empty($program_err)) ? 'is-invalid' : ''; ?>">
                            <option value="">Select Program</option>
                            <option value="CS" <?php if ($program == "CS") echo "selected"; ?>>CS</option>
                            <option value="IT" <?php if ($program == "IT") echo "selected"; ?>>IT</option>
                            <option value="IS" <?php if ($program == "IS") echo "selected"; ?>>IS</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $program_err; ?></span>
                    </div>


                    <!--radio button-->
                    <div class="form-group">
                        <label>Sex</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sex" id="male" value="Male" <?php if ($sex === "Male") echo "checked"; ?>>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sex" id="female" value="Female" <?php if ($sex === "Female") echo "checked"; ?>>
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <span class="invalid-feedback"><?php echo $sex_err; ?></span>
                    </div>


                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>">
                            <span class="invalid-feedback"><?php echo $image_err; ?></span>
                        </div>
                       
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
