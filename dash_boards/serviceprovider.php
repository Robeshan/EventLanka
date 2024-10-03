<?php
session_start();
require_once '../Classes/Database.php';
require_once '../Classes/User.php';

$database = new Database();
$db = $database->getConnection();

$userId = $_SESSION['user_id'];

// Fetch user data
$user = new User($db);
$userData = $user->fetchUserData($userId); // Assuming fetchUserData method exists in User class

if (!$userData) {
    $_SESSION['error'] = "User data not found.";
    header('Location: ../login/login_form.php');
    exit();
}

// Display user data
$username = htmlspecialchars($userData['username'] ?? ''); // Default to empty string if not set
$userEmail = htmlspecialchars($userData['email'] ?? ''); // Default to empty string if not set
$profilePicture = htmlspecialchars($userData['profile_picture'] ?? 'default_avatar.png'); // Fallback to default image if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Dashboard</title>
    <link rel="stylesheet" href="../css/provider.css">
</head>
<body>
    <div class="sidebar">
        <h2>Service Provider Dashboard</h2>
        <ul>
            <li><a href="#S_Dashboard">Dashboard</a></li>
            <li><a href="#S_Profile">Profile</a></li>
            <li><a href="#S_Services">My Services</a></li>
            <li><a href="#S_Notifications">Notifications</a></li>
            <li><a href="#S_Payments">Payments</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
        <h1>Welcome To The Event Lanka, <?php echo htmlspecialchars($username); ?>!</h1>
        </header>
        <section class="profile" id="S_Profile">
            <h2>My Profile</h2>
            <form id="profileForm" method="POST" enctype="multipart/form-data" action="../bacend_logics_scripts/service_update_profile copy.php">
                <img src="<?php echo $profilePicture; ?>" alt="User Avatar" class="user-avatar" id="userAvatar">
                <label for="username">Name:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>

                <label for="userEmail">Email:</label>
                <input type="email" id="userEmail" name="userEmail" value="<?php echo $userEmail; ?>" required>

                <label for="profilePicture">Profile Picture:</label>
                <input type="file" id="profilePicture" name="profilePicture">

                <button type="submit">Update Profile</button>
            </form>
        </section>
        
        <?php
                require_once '../Classes/Database.php'; // Adjust the path as necessary

                $database = new Database();
                $db = $database->getConnection();

                // Initialize variables
                $totalServices = 0;
                $totalBookings = 0;
                $totalIncome = 0;

                // Get total services
                $queryServices = "SELECT COUNT(*) as total FROM serviceprovider WHERE userId = :userId"; // Adjust the table if needed
                $stmtServices = $db->prepare($queryServices);
                $stmtServices->bindParam(':userId', $_SESSION['user_id']); // Assuming you have user_id in session
                $stmtServices->execute();
                $totalServices = $stmtServices->fetchColumn();

                // Get total bookings
                $queryBookings = "SELECT COUNT(*) as total FROM usereventbooking WHERE userId = :userId"; // Adjust the table if needed
                $stmtBookings = $db->prepare($queryBookings);
                $stmtBookings->bindParam(':userId', $_SESSION['user_id']); // Assuming you have user_id in session
                $stmtBookings->execute();
                $totalBookings = $stmtBookings->fetchColumn();

                // Get total income
                $queryIncome = "SELECT SUM(amount) as total FROM payment WHERE userId = :userId"; // Adjust the table if needed
                $stmtIncome = $db->prepare($queryIncome);
                $stmtIncome->bindParam(':userId', $_SESSION['user_id']); // Assuming you have user_id in session
                $stmtIncome->execute();
                $totalIncome = $stmtIncome->fetchColumn();
                ?>


        <section class="dashboard-overview" id="S_Dashboard">
    <h2>Dashboard Overview</h2>
    <div class="card">
        <h3>Total Services</h3>
        <p><?php echo htmlspecialchars($totalServices); ?></p>
    </div>
    <div class="card">
        <h3>Total Bookings</h3>
        <p><?php echo htmlspecialchars($totalBookings); ?></p>
    </div>
    <div class="card">
        <h3>Total Income</h3>
        <p>$<?php echo htmlspecialchars($totalIncome); ?></p>
    </div>
</section>

<?php
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

        <section class="my-services" id="S_Services">
            <h2>My Services</h2>
            <form id="serviceForm" action="../bacend_logics_scripts/upload_service.php" method="post">

                <label for="serviceName">Service Name:</label>
                <input type="text" id="serviceName" name="serviceName" required>

                <label for="serviceDescription">Description:</label>
                <textarea id="serviceDescription" name="serviceDescription" rows="4" cols="50" required></textarea>

                <button type="submit">Upload Service</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                        require_once '../Classes/Database.php'; 
                        require_once '../Classes/Service.php'; // Include the Service class

                        $database = new Database();
                        $db = $database->getConnection();

                        // Create Service object
                        $service = new Service($db);

                        // Fetch services for the logged-in user
                        $services = $service->fetchServicesByUserId($_SESSION['user_id']); // Adjust according to your method

                        // Now you can safely check if $services is empty
                        if (empty($services)) {
                            echo '<tr><td colspan="3">No services found.</td></tr>';
                        } else {
                            foreach ($services as $service) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($service['serviceName']) . '</td>';
                                echo '<td>' . htmlspecialchars($service['serviceDescription']) . '</td>';
                                echo '<td>
                                        <form action="../bacend_logics_scripts/modify_service_process.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="service_id" value="' . htmlspecialchars($service['serviceId']) . '">
                                            <input type="hidden" name="action" value="modify">
                                            <button type="submit">Modify</button>
                                        </form>
                                        <form action="../bacend_logics_scripts/service_action.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="service_id" value="' . htmlspecialchars($service['serviceId']) . '">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit">Delete</button>
                                        </form>
                                    </td>';
                                echo '</tr>';
                            }
                        }
                        ?>

                </tbody>
            </table>
        </section>

        <section class="notifications" id="S_Notifications">
            <h2>Notifications</h2>
            <ul>
                <li>Notification 1: New booking for Wedding Catering on 2023-07-12</li>
                <li>Notification 2: Admin approved your new service</li>
            </ul>
        </section>

        <section class="payments" id="S_Payments">
            <h2>Payments</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order Count</th>
                        <th>Completed Orders</th>
                        <th>Pending Orders</th>
                        <th>Amount Paid</th>
                        <th>Pending Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>20</td>
                        <td>15</td>
                        <td>5</td>
                        <td>$3000</td>
                        <td>$2000</td>
                    </tr>
                </tbody>
            </table>
        </section>

     

    <script>
        // Chart.js for reports
        var ctx1 = document.getElementById('incomeChart').getContext('2d');
        var incomeChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Income',
                    data: [1200, 1900, 3000, 500, 2000, 3000, 4500],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('serviceChart').getContext('2d');
        var serviceChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Wedding Catering', 'DJ Services', 'Event Planning', 'Decoration Services'],
                datasets: [{
                    label: 'Services',
                    data: [10, 15, 5, 7],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    </script>
</body>
</html>
