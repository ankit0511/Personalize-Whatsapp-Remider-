document.addEventListener("DOMContentLoaded", function () {
    var reminderForm = document.getElementById("reminderForm");
    var messageInput = document.getElementById("message");
    var datetimeInput = document.getElementById("datetime");
    var createReminderButton = document.getElementById("createReminder");
    var reminderDetails = document.getElementById("reminderDetails");

    reminderForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission behavior

        var message = messageInput.value;
        var datetime = datetimeInput.value;

        if (message.trim() === '' || datetime.trim() === '') {
            alert("Please fill in all fields.");
            return;
        }

        // Create a new box to display the reminder details
        var newBox = document.createElement("div");
        newBox.className = "reminder-box";
        newBox.innerHTML = "<strong>Reminder:</strong> " + message + "<br><strong>Date and Time:</strong> " + datetime;

        // Create a delete button for this reminder
        var deleteButton = document.createElement("button");
        deleteButton.textContent = "Delete";
        deleteButton.addEventListener("click", function () {
            // Remove the reminder box when the delete button is clicked
            reminderDetails.removeChild(newBox);
        });

        newBox.appendChild(deleteButton); // Append the delete button to the reminder box
        reminderDetails.appendChild(newBox);

        // Clear input fields
        messageInput.value = "";
        datetimeInput.value = "";

        // Add code here to send form data to the database (e.g., using AJAX or a form submission)
        // Example AJAX call:
        // fetch('insert.php', {
        //     method: 'POST',
        //     body: new FormData(reminderForm)
        // })
        // .then(response => response.text())
        // .then(data => console.log(data))
        // .catch(error => console.error('Error:', error));
        
        // You can also use a form submission, specifying the form's action attribute:
        // reminderForm.submit();
    });
});
