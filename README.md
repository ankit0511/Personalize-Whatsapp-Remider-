# Personalize Whatsaa Reminder

Personalize Whatsaa Reminder is a PHP-based application that allows users to schedule WhatsApp messages to be sent at specific dates and times. By leveraging Twilio’s API, WebSockets, and a SQL database, this project provides a seamless way to ensure important reminders are never missed.

## Features

- **Schedule WhatsApp Messages:** Set reminders to be sent at any desired date and time.
- **Twilio API Integration:** Utilizes Twilio's API to send messages via WhatsApp.
- **Real-Time Updates:** Uses WebSockets for real-time updates and notifications.
- **User-Friendly Interface:** Easy-to-use web interface for managing reminders.

## Screenshots

**Reminder Set Successfully:**

![Reminder Set Successfully](https://via.placeholder.com/800x400.png?text=Reminder+Set+Successfully)
*Image Source: [Unsplash](https://unsplash.com)*

**Reminder Sent Successfully:**

![Reminder Sent Successfully](https://via.placeholder.com/800x400.png?text=Reminder+Sent+Successfully)
*Image Source: [Pexels](https://www.pexels.com)*

**Sending Message:**

![Sending Message](https://via.placeholder.com/800x400.png?text=Sending+Message)
*Image Source: [Pixabay](https://pixabay.com)*

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL
- Composer
- Node.js (for WebSocket server)

### Steps

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/yourusername/personalize-whatsaa-reminder.git
    cd personalize-whatsaa-reminder
    ```

2. **Install Dependencies:**

    For PHP dependencies:
    ```bash
    composer install
    ```

    For WebSocket server:
    ```bash
    npm install
    ```

3. **Setup Environment Variables:**

    Copy the `.env.example` file to `.env` and update the environment variables with your Twilio API credentials and database configuration:

    ```bash
    cp .env.example .env
    ```

4. **Create and Configure the Database:**

    Import the provided SQL schema into your MySQL database:
    ```bash
    mysql -u username -p database_name < database_schema.sql
    ```

5. **Run the WebSocket Server:**

    ```bash
    node websocket-server.js
    ```

6. **Start the PHP Server:**

    ```bash
    php -S localhost:8000
    ```

## Usage

1. **Access the Application:**
   Open your browser and go to `http://localhost:8000`.

2. **Create an Account:**
   Sign up or log in to your account.

3. **Set a Reminder:**
   Use the web interface to schedule a WhatsApp message. Enter the desired date, time, and message content.

4. **View and Manage Reminders:**
   View, edit, or delete scheduled reminders from the dashboard.

## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeature`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Create a new Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgements

- [Twilio API](https://www.twilio.com/)
- [PHP](https://www.php.net/)
- [WebSockets](https://developer.mozilla.org/en-US/docs/Web/API/WebSockets_API)
- [MySQL](https://www.mysql.com/)
