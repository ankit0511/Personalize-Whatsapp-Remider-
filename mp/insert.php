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
    echo "hii2<br>";

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
        echo "No reminders found for sending.";
    }

    // Close the database connection
    $conn->close();
}

// Call the function to start the process
sendReminders();
?>

<script>
    // Reload the script every minute
    setTimeout(function () {
        location.reload();
    }, 60000);
</script>
