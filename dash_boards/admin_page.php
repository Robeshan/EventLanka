<?php
session_start();



require_once '../Classes/Database.php';
require_once '../Classes/User.php';

$database = new Database();
$db = $database->getConnection();

$userId = $_SESSION['user_id'];

// Fetch user data
$user = new User($db);
$userData = $user->fetchUserData($userId);

if (!$userData) {
    $_SESSION['error'] = "User data not found.";
    header('Location: ../login/login_form.php');
    exit();
}

// Sanitize user data
$username = htmlspecialchars($userData['username'] ?? ''); 
$userEmail = htmlspecialchars($userData['email'] ?? ''); 
$userAvatar = htmlspecialchars($userData['profilePicture'] ?? 'uploads/default.png'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <ul>
        <li><a href="#A_Dashboard">Dashboard</a></li>
        <li><a href="#User Management">User Management</a></li>
        <li><a href="#Service Providers">Service Provider Management</a></li>
        <li><a href="#Services">Services Management</a></li>
        <li><a href="#A_Packages">Packages Management</a></li>
        <li><a href="#Event Management">Event Management</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <header>
        <h1>Welcome Back Sir.. <?php echo $username; ?>!</h1>
    </header>

    <section class="section" id="A_Dashboard">
        <h2>Dashboard Overview</h2>
        <p>Total Users: 1500</p>
        <p>Total Events: 120</p>
        <p>Pending Approvals: 10</p>
    </section>

    <section class="section" id="User Management">
        <h2>User Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Profile Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../Classes/Database.php';
                $database = new Database();
                $db = $database->getConnection();

                // Fetch users from the database
                $usersQuery = "SELECT * FROM user"; // Adjust the query as needed
                $stmt = $db->prepare($usersQuery);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td><img src="uploads/' . htmlspecialchars($row['profilePicture'] ?? 'default.png') . '" alt="User Avatar" width="40"></td>';
                    echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['userType']) . '</td>';
                    echo '<td>
                            <form action="#" method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="' . $row['userId'] . '">
                                <input type="hidden" name="action" value="block">
                                <button type="submit">Block</button>
                            </form>
                            <form action="#" method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="' . $row['userId'] . '">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit">Approve</button>
                            </form>
                            <form action="#" method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="' . $row['userId'] . '">
                                <input type="hidden" name="action" value="reject">
                                <button type="submit">Reject</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <section class="section" id="Service Providers">
        <h2>Service Provider Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Profile Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Service Details</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch service providers from the database
                $serviceProvidersQuery = "SELECT * FROM serviceprovider"; // Adjust the query as needed
                $stmt = $db->prepare($serviceProvidersQuery);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td><img src="uploads/' . htmlspecialchars($row['profileImage'] ?? 'default.png') . '" alt="Provider Avatar" width="40"></td>';
                    echo '<td>' . htmlspecialchars($row['providerName']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['contactInfo']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['serviceDetails']) . '</td>';
                    echo '<td>
                            <form action="#" method="POST" style="display: inline;">
                                <input type="hidden" name="provider_id" value="' . $row['providerId'] . '">
                                <input type="hidden" name="action" value="block">
                                <button type="submit">Block</button>
                            </form>
                            <form action="#" method="POST" style="display: inline;">
                                <input type="hidden" name="provider_id" value="' . $row['providerId'] . '">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit">Approve</button>
                            </form>
                            <form action="#" method="POST" style="display: inline;">
                                <input type="hidden" name="provider_id" value="' . $row['providerId'] . '">
                                <input type="hidden" name="action" value="reject">
                                <button type="submit">Reject</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <section class="section" id="Services">
<h2>Services Management</h2>
<table>
    <thead>
        <tr>
            <th>Service Name</th>
            <th>Description</th>
            <th>Provider</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch services from the database
        $servicesQuery = "
        SELECT s.serviceId, s.serviceName, s.serviceDescription, sp.providerName, s.status 
        FROM services s
        JOIN serviceprovider sp ON s.userId = sp.userId"; // Join on userId

        $stmt = $db->prepare($servicesQuery);
        $stmt->execute();

        // Check if the query was successful
        if ($stmt) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['serviceName']) . '</td>';
                echo '<td>' . htmlspecialchars($row['serviceDescription']) . '</td>';
                echo '<td>' . htmlspecialchars($row['providerName']) . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                echo '<td>
                        <form action="#" method="POST" style="display: inline;">
                            <input type="hidden" name="service_id" value="' . htmlspecialchars($row['serviceId']) . '">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit">Approve</button>
                        </form>
                        <form action="#" method="POST" style="display: inline;">
                            <input type="hidden" name="service_id" value="' . htmlspecialchars($row['serviceId']) . '">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit">Reject</button>
                        </form>
                      </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">No services available.</td></tr>'; // Handle no services case
        }
        ?>
    </tbody>
</table>
</section>



<section class="section" id="A_Packages">
    <h2>Package Management</h2>
    <form action="../bacend_logics_scripts/package_management.php" method="POST"> <!-- Added action and method -->
        <label for="packageSelect">Select Package:</label>
        <select id="packageSelect" name="packageSelect"> <!-- Added name attribute -->
            <option value="wedding">Wedding Package</option>
            <!-- More options as needed -->
        </select>

        <label for="packageDetails">Update Details:</label>
        <textarea id="packageDetails" name="packageDetails" rows="4" required></textarea> <!-- Added name attribute -->

        <label for="serviceProviders">Link Service Providers:</label>
        <select id="serviceProviders" name="serviceProviders"> <!-- Added name attribute -->
            <option value="catering">Event Catering</option>
            <!-- More options as needed -->
        </select>

        <label for="packagePrice">Package Price:</label>
        <input type="number" id="packagePrice" name="packagePrice" required> <!-- Added name attribute -->

        <button type="submit">Update Package</button>
    </form>
</section>

<section class="section" id="Event Management">
    <h2>Event Management</h2>
    <form action="../bacend_logics_scripts/event_management.php" method="POST">
        <label for="eventName">Event Name:</label>
        <input type="text" id="eventName" name="eventName" required>

        <label for="eventType">Event Type:</label>
        <select id="eventType" name="eventType">
            <option value="Wedding">Wedding</option>
            <option value="Corporate">Corporate</option>
            <option value="Party">Party</option>
            <!-- Add more event types as needed -->
        </select>

        <label for="eventDescription">Event Description:</label>
        <textarea id="eventDescription" name="eventDescription" rows="4" required></textarea>

        <label for="eventDate">Event Date:</label>
        <input type="date" id="eventDate" name="eventDate" required>

        <label for="eventVenue">Event Venue:</label>
        <input type="text" id="eventVenue" name="eventVenue" required>

        <label for="noOfGuests">Number of Guests:</label>
        <input type="number" id="noOfGuests" name="noOfGuests" required>

        <button type="submit">Add Event</button>
    </form>
</section>

    <h3>Existing Events</h3>
    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Event Type</th>
                <th>Description</th>
                <th>Date</th>
                <th>Venue</th>
                <th>Guests</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch existing events from the database
            $eventsQuery = "SELECT * FROM event"; // Adjust the query as needed
            $stmt = $db->prepare($eventsQuery);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['eventName']) . '</td>';
                echo '<td>' . htmlspecialchars($row['eventType']) . '</td>';
                echo '<td>' . htmlspecialchars($row['eventDescription']) . '</td>';
                echo '<td>' . htmlspecialchars($row['eventDate']) . '</td>';
                echo '<td>' . htmlspecialchars($row['eventVenue']) . '</td>';
                echo '<td>' . htmlspecialchars($row['noOfGuests']) . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</section>

</div>
<script>
// Uncomment if needed
// document.querySelectorAll('form').forEach(form => {
//     form.addEventListener('submit', function(event) {
//         event.preventDefault();
//         alert('Form Submitted');
//     });
// });
</script>
</body>
</html>
