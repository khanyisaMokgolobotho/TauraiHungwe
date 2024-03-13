<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from POST request
    $name = $_POST['Name'];
    $email = $_POST['email'];
    $message = $_POST['Message'];
    
    // Ensure all fields are filled before submission
    if (empty($name) || empty($email) || empty($message)) {
        echo "Please fill out all fields";
        exit;
    }
    
    // Validate the email entered
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }
    
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'group'); // Assuming your database name is 'group'
    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    }
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO students (name, email, text) VALUES (?, ?, ?)");
    
    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sss", $name, $email, $message); // Assuming all columns are VARCHAR
        
        // Set parameters and execute
        $stmt->execute();
        
        echo "Request submitted.....";
        
        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    
    // Close connection
    $conn->close();
}
?>
