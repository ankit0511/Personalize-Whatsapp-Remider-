<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Reminder</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 
</head>
<body>

<?php
// connecting to the database
$insert = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "reminder";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Sorry, we failed to connect.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST["message"];
    $time = $_POST["time"];

    $sql = "INSERT INTO `task` (`message`, `time`) VALUES ('$message', '$time')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $insert=true;
        // Perform a redirect to avoid form resubmission
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit; // Terminate this script to ensure the redirect takes effect
    } else {
        echo "The record was not inserted successfully because of: " . mysqli_error($conn);
    }
}
?>

<!-- Rest of your HTML code remains the same -->


<?php
if($insert){
echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
<strong>Success !</strong> Your Reminder added successfully  
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
?>
 <div class="container">
    <div class="reminder-box">
        <h1>Create a Message Reminder</h1>
        <form id="reminderForm" action="/mp/index.php" method="post">
            <div class="input-group">
                <label for="message">Message:</label>
                <input type="text" id="message" name="message" required>
            </div>
            <div class="input-group">
                <label for="datetime">Date and Time:</label>
                <input type="datetime-local" id="time" name="time" required>
            </div>
            <div class="button-group">
                <button type="submit" id="createReminder">Create Reminder</button>
            </div>
        </form>
     </div>
     </div>
     <div class="container">

<table class="table">
  <thead>
    <tr>
      <th scope="col">Sno </th>
      <th scope="col">Message </th>
      <th scope="col">time</th>
      <th scope="col">Acions</th>
    </tr>
  </thead>
  <tbody>
  <?php

echo"<br>";
$sql= "SELECT * FROM `task`";
$result = mysqli_query($conn, $sql);
$num=0;
while( $row=mysqli_fetch_assoc($result)){
    $num +=1;
    echo " <tr>
    <th scope='row'>".$num."</th>
    <td><b>".$row['message']."</b></td>
    <td>".$row['time']."</td>
    <td>   <a href='/mp/index.php?id=" . $row['id'] . "'>Delete</a>   </td>

    
  </tr>";
    
}
?>

<?php
// Include your database connection code here

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the DELETE SQL statement
    $sql = "DELETE FROM task WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Your Reminder</strong> Removed Successfully 
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    } else {
        echo "Error: Unable to delete record.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
  </tbody>
</table>
</div>
<?php
date_default_timezone_set('Asia/Kolkata'); // Set the timezone to Indian Standard Time (IST)

// Database connection information
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reminder";
echo "hiii<br>";

function sendReminders() {
    // Create a database connection
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
   

    // Fetch reminders from the database
    $sql = "SELECT * FROM task WHERE sent = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reminderTime = strtotime($row["time"]);
            $currentTime = time();
            $reminderTimeIST = $reminderTime + 19800; // Convert to IST (5 hours and 30 minutes)
            $currentTimeIST = $currentTime + 19800; // Convert to IST (5 hours and 30 minutes)

            echo "Reminder Time (IST): " . date('Y-m-d H:i:s', $reminderTimeIST) . ", Current Time (IST): " . date('Y-m-d H:i:s', $currentTimeIST) . "<br>";

            if ($reminderTimeIST <= $currentTimeIST) {
                $reminderId = $row["id"];
                $message = $row["message"];
                echo "hii4<br>";

                // Send the message using Twilio
                // Replace with your Twilio configuration
                $accountSid = "ACb81e372d0fd7c1ea03f90118816c9509";
                $authToken =  "9792def301f1d9d0173359b1fd3cc269";

                // Initialize Twilio client
                require_once 'C:\xampp\htdocs\reminder\twilio-php-main\twilio-php-main\src/Twilio/autoload.php';

                $client = new Twilio\Rest\Client($accountSid, $authToken);

                // Replace with your WhatsApp numbers
                $from = "whatsapp:+14155238886";
                $to = "whatsapp:+917489887741";  // Your recipient's WhatsApp number

                $message = $client->messages->create($to, [
                    "from" => $from,
                    "body" => $message,
                ]);

                // Mark the reminder as "sent" in the database
                $updateSql = "UPDATE task SET sent = 1 WHERE id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("i", $reminderId);
                $updateStmt->execute();

                echo "Message sent with SID: " . $message->sid . " for reminder ID: " . $reminderId . "<br>";
            }
        }
    } else {
        echo "";
    }

    // Close the database connection
    $conn->close();
}

// Call the function to start the process
sendReminders();
?>




 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
 <script>
    // Reload the page every minute (60,000 milliseconds)
    setTimeout(function () {
        location.reload();
    }, 60000);
</script>

</body>
</html>
