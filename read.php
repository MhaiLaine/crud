<?php
// Check existence of id parameter before processing further
if (isset($_GET["student_no"]) && !empty(trim($_GET["student_no"]))) {
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM student WHERE student_no = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_student_no);

        // Set parameters
        $param_student_no = trim($_GET["student_no"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // Retrieve individual field value
                $last_name = $row["last_name"];
                $first_name = $row["first_name"];
                $middle_name = $row["middle_name"];
                $birthday = $row["birthday"];
                $program = $row["program"];
                $sex = $row["sex"];
                $address = $row["address"];
                $image = $row["image"];

            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Last Name</label>
                        <p><b><?php echo $row["last_name"]; ?></b></p>
                    </div>

                    <div class="form-group">
                        <label>First Name</label>
                        <p><b><?php echo $row["first_name"]; ?></b></p>
                    </div>

                    <div class="form-group">
                        <label>Middle Name</label>
                        <p><b><?php echo $row["middle_name"]; ?></b></p>
                    </div>

                    <div class="form-group">
                        <label>Birthday</label>
                        <p><b><?php echo $row["birthday"]; ?></b></p>
                    </div>

                    <div class="form-group">
                        <label>Program</label>
                        <p><b><?php echo $row["program"]; ?></b></p>
                    </div>

                    <div class="form-group">
                        <label>Sex</label>
                        <p><b><?php echo $row["sex"]; ?></b></p>
                    </div>
                    
                    <div class="form-group">
                        <label>Address</label>
                        <p><b><?php echo $row["address"]; ?></b></p>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <p><b><?php echo $row["image"]; ?></b></p>
                    </div>


                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>