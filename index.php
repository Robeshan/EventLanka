<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project01;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>

<?php

require_once 'config.php';

function getUserByUsername($username)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getUserByEmail($email)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function registerUser($username, $email, $phoneNumber, $nicNumber, $password, $confirmPassword, $nicPhotos, $userType)
{
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO Users (Username, Email, PhoneNumber, NICNumber, Password, ConfirmPassword, NICPhotos, UserType) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $username, $email, $phoneNumber, $nicNumber, $hashed_password, $hashed_password, $nicPhotos, $userType);
    return $stmt->execute();
}

function loginUser($username, $password)
{
    $user = getUserByUsername($username);
    if ($user && password_verify($password, $user['Password'])) {
        return $user;
    }
    return false;
}

function getEventTypeByID($eventTypeID)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM EventTypes WHERE EventTypeID = ?");
    $stmt->bind_param("i", $eventTypeID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getEventByID($eventID)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Events WHERE EventID = ?");
    $stmt->bind_param("i", $eventID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getServiceByID($serviceID)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Services WHERE ServiceID = ?");
    $stmt->bind_param("i", $serviceID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function bookEvent($userID, $eventID, $serviceID, $bookingDate, $advancePayment, $balancePayment)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Bookings (UserID, EventID, ServiceID, BookingDate, AdvancePayment, BalancePayment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissdd", $userID, $eventID, $serviceID, $bookingDate, $advancePayment, $balancePayment);
    return $stmt->execute();
}

function addFeedback($userID, $eventID, $feedbackText, $rating)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Feedback (UserID, EventID, FeedbackText, Rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiisi", $userID, $eventID, $feedbackText, $rating);
    return $stmt->execute();
}

function getAdminByUsername($username)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Admins WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getOwnerPhotographerByID($ownerPhotographerID)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM OwnersPhotographers WHERE OwnerPhotographerID = ?");
    $stmt->bind_param("i", $ownerPhotographerID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
?>


<?php
require_once 'functions.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'register':
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $nicNumber = $_POST['nicNumber'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $nicPhotos = isset($_FILES['nicPhotos']) ? $_FILES['nicPhotos'] : '';
        $userType = $_POST['userType'];
        if (registerUser($username, $email, $phoneNumber, $nicNumber, $password, $confirmPassword, $nicPhotos, $userType)) {
            echo 'Registration successful';
        } else {
            echo 'Registration failed';
        }
        break;
    case 'login':
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = loginUser($username, $password);
        if ($user) {
            echo 'Login successful';
            session_start();
            $_SESSION['user'] = $user;
        } else {
            echo 'Login failed';
        }
        break;
    case 'bookEvent':
        $userID = $_SESSION['user']['UserID'];
        $eventID = $_POST['eventID'];
        $serviceID = $_POST['serviceID'];
        $bookingDate = $_POST['bookingDate'];
        $advancePayment = $_POST['advancePayment'];
        $balancePayment = $_POST['balancePayment'];
        if (bookEvent($userID, $eventID, $serviceID, $bookingDate, $advancePayment, $balancePayment)) {
            echo 'Event booked successfully';
        } else {
            echo 'Failed to book event';
        }
        break;
    case 'addFeedback':
        $userID = $_SESSION['user']['UserID'];
        $eventID = $_POST['eventID'];
        $feedbackText = $_POST['feedbackText'];
        $rating = $_POST['rating'];
        if (addFeedback($userID, $eventID, $feedbackText, $rating)) {
            echo 'Feedback submitted successfully';
        } else {
            echo 'Failed to submit feedback';
        }
        break;
}
?>


<form action="index.php?action=bookEvent" method="post">
    <input type="hidden" name="eventID" value="1">
    <input type="hidden" name="serviceID" value="1">
    <label for="bookingDate">Booking Date:</label>
    <input type="date" id="bookingDate" name="bookingDate" required>
    <label for="advancePayment">Advance Payment:</label>
    <input type="number" id="advancePayment" name="advancePayment" required>
    <label for="balancePayment">Balance Payment:</label>
    <input type="number" id="balancePayment" name="balancePayment" required>
    <button type="submit">Book Event</button>
</form>



<form action="index.php?action=addFeedback" method="post">
    <input type="hidden" name="eventID" value="1">
    <label for="feedbackText">Feedback:</label>
    <textarea id="feedbackText" name="feedbackText" required></textarea>
    <label for="rating">Rating:</label>
    <select id="rating" name="rating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    <button type="submit">Submit Feedback</button>
</form>



<?php
require_once 'functions.php';

$eventTypeID = 1;
$eventType = getEventTypeByID($eventTypeID);

echo '<h1>' . $eventType['EventTypeName'] . '</h1>';
echo '<p>' . $eventType['EventTypeDescription'] . '</p>';
?>

<?php
require_once 'functions.php';

$serviceID = 1;
$service = getServiceByID($serviceID);

echo '<h1>' . $service['ServiceName'] . '</h1>';
echo '<p>' . $service['ServiceDescription'] . '</p>';
echo '<p>Price: $' . $service['ServicePrice'] . '</p>';
?>


<?php
require_once 'functions.php';

$eventTypeID = 1;
$events = getEventsByTypeID($eventTypeID);

foreach ($events as $event) {
    echo '<h1>' . $event['EventName'] . '</h1>';
    echo '<p>' . $event['EventDescription'] . '</p>';
    echo '<p>Date: ' . $event['EventDate'] . '</p>';
    echo '<p>Venue: ' . $event['Venue'] . '</p>';
}
?>


<?php
require_once 'functions.php';

$eventID = 1;
$event = getEventByID($eventID);

echo '<h1>' . $event['EventName'] . '</h1>';
echo '<p>' . $event['EventDescription'] . '</p>';
echo '<p>Date: ' . $event['EventDate'] . '</p>';
echo '<p>Venue: ' . $event['Venue'] . '</p>';

$eventType = getEventTypeByID($event['EventTypeID']);
echo '<p>Event Type: ' . $eventType['EventTypeName'] . '</p>';

$service = getServiceByID($event['ServiceID']);
echo '<p>Service: ' . $service['ServiceName'] . '</p>';
echo '<p>Price: $' . $service['ServicePrice'] . '</p>';
?>


<?php
require_once 'functions.php';

$userID = 1;
$bookings = getEventBookingsByUserID($userID);

foreach ($bookings as $booking) {
    $event = getEventByID($booking['EventID']);
    $service = getServiceByID($booking['ServiceID']);

    echo '<h1>' . $event['EventName'] . '</h1>';
    echo '<p>Booking Date: ' . $booking['BookingDate'] . '</p>';
    echo '<p>Advance Payment: $' . $booking['AdvancePayment'] . '</p>';
    echo '<p>Balance Payment: $' . $booking['BalancePayment'] . '</p>';
    echo '<p>Service: ' . $service['ServiceName'] . '</p>';
    echo '<p>Price: $' . $service['ServicePrice'] . '</p>';
}
?>



<?php
require_once 'functions.php';

$eventID = 1;
$feedbacks = getEventFeedbacksByEventID($eventID);

foreach ($feedbacks as $feedback) {
    $user = getUserByID($feedback['UserID']);

    echo '<h1>' . $user['Username'] . '</h1>';
    echo '<p>' . $feedback['FeedbackText'] . '</p>';
    echo '<p>Rating: ' . $feedback['Rating'] . '</p>';
}
?>



<<?php
require_once 'functions.php';

switch ($_GET['action']) {
    case 'register':
        if (isset($_POST['register'])) {
            registerUser($_POST);
            header('Location: login.php');
        }
        break;

    case 'login':
        if (isset($_POST['login'])) {
            $user = getUserByCredentials($_POST['username'], $_POST['password']);

            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: dashboard.php');
            } else {
                $errorMessage = 'Invalid username or password.';
            }
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php');
        break;
}
?>




<?php
require_once 'functions.php';

$userID = $_SESSION['user']['UserID'];
$userDashboard = userDashboard($userID);

echo '<h1>' . $userDashboard['Username'] . '</h1>';
echo '<p>Email: ' . $userDashboard['Email'] . '</p>';
echo '<p>Bookings: ' . $userDashboard['Bookings'] . '</p>';
?>





<?php
require_once 'functions.php';

if (isset($_POST['book'])) {
    $userID = $_SESSION['user']['UserID'];
    $eventID = $_GET['event_id'];
    $serviceID = $_GET['service_id'];
    $bookingDate = date('Y-m-d H:i:s');
    $advancePayment = $_POST['advance_payment'];
    $balancePayment = $_POST['balance_payment'];

    bookEvent($userID, $eventID, $serviceID, $bookingDate, $advancePayment, $balancePayment);

    header('Location: event-bookings.php');
}
?>


<?php
require_once 'functions.php';

$userID = $_SESSION['user']['UserID'];
$bookings = getEventBookingsByUserID($userID);

foreach ($bookings as $booking) {
    $event = getEventByID($booking['EventID']);
    $service = getServiceByID($booking['ServiceID']);

    echo '<h1>' . $event['EventName'] . '</h1>';
    echo '<p>Booking Date: ' . $booking['BookingDate'] . '</p>';
    echo '<p>Advance Payment: $' . $booking['AdvancePayment'] . '</p>';
    echo '<p>Balance Payment: $' . $booking['BalancePayment'] . '</p>';
    echo '<p>Service: ' . $service['ServiceName'] . '</p>';
    echo '<p>Price: $' . $service['ServicePrice'] . '</p>';
}
?>




<?php
require_once 'functions.php';

if (isset($_POST['submit'])) {
    $userID = $_SESSION['user']['UserID'];
    $eventID = $_GET['event_id'];
    $feedbackText = $_POST['feedback_text'];
    $rating = $_POST['rating'];

    submitFeedback($userID, $eventID, $feedbackText, $rating);

    header('Location: event-feedbacks.php');
}
?>








<?php
require_once 'functions.php';

$eventID = $_GET['event_id'];
$feedbacks = getEventFeedbacksByEventID($eventID);

foreach ($feedbacks as $feedback) {
    $user = getUserByID($feedback['UserID']);

    echo '<h1>' . $user['Username'] . '</h1>';
    echo '<p>' . $feedback['FeedbackText'] . '</p>';
    echo '<p>Rating: ' . $feedback['Rating'] . '</p>';
}
?>




<?php
require_once 'functions.php';

$adminID = $_SESSION['admin']['AdminID'];
$adminDashboard = adminDashboard($adminID);

echo '<h1>' . $adminDashboard['Username'] . '</h1>';
echo '<p>Email: ' . $adminDashboard['Email'] . '</p>';
echo '<p>Total Users: ' . $adminDashboard['TotalUsers'] . '</p>';
echo '<p>Total Events: ' . $adminDashboard['TotalEvents'] . '</p>';
echo '<p>Total Services: ' . $adminDashboard['TotalServices'] . '</p>';
?>







<?php
require_once 'functions.php';

$ownerPhotographerID = $_SESSION['owner_photographer']['OwnerPhotographerID'];
$ownerPhotographerDashboard = ownerPhotographerDashboard($ownerPhotographerID);

echo '<h1>' . $ownerPhotographerDashboard['Name'] . '</h1>';
echo '<p>Email: ' . $ownerPhotographerDashboard['Email'] . '</p>';
echo '<p>Phone Number: ' . $ownerPhotographerDashboard['PhoneNumber'] . '</p>';
echo '<p>NIC Number: ' . $ownerPhotographerDashboard['NICNumber'] . '</p>';
?>



<?php
require_once 'functions.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $nicNumber = $_POST['nic_number'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $nicPhotos = $_FILES['nic_photos'];
    $userType = $_POST['user_type'];

    registerUser($username, $email, $phoneNumber, $nicNumber, $password, $confirmPassword, $nicPhotos, $userType);

    header('Location: login.php');
}
?>





<?php
require_once 'functions.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = loginUser($username, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: user-dashboard.php');
    } else {
        $errorMessage = 'Invalid username or password.';
    }
}
?>


<?php
require_once 'functions.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $nicNumber = $_POST['nic_number'];

    registerAdmin($username, $email, $password, $confirmPassword, $nicNumber);

    header('Location: login.php');
}
?>


<?php
require_once 'functions.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $admin = loginAdmin($username, $password);

    if ($admin) {
        $_SESSION['admin'] = $admin;
        header('Location: admin-dashboard.php');
    } else {
        $errorMessage = 'Invalid username or password.';
    }
}
?>





<?php
require_once 'functions.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $admin = loginAdmin($username, $password);

    if ($admin) {
        $_SESSION['admin'] = $admin;
        header('Location: admin-dashboard.php');
    } else {
        $errorMessage = 'Invalid username or password.';
    }
}
?>


<?php
require_once 'functions.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $nicNumber = $_POST['nic_number'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    registerOwnerPhotographer($name, $email, $phoneNumber, $nicNumber, $password, $confirmPassword);

    header('Location: login.php');
}
?>





























