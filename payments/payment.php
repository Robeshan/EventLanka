<?php
session_start();
include '../Classes/Database.php'; 

// Initialize the database connection
$database = new Database();
$conn = $database->getConnection(); // Get the PDO connection object

// Check if userId is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}

$userId = $_SESSION['user_id']; // Get the logged-in user's ID

function generateOTP() {
    return rand(100000, 999999);
}

function encryptOTP($otp) {
    return password_hash($otp, PASSWORD_DEFAULT);
}

function sendOTPEmail($email, $otp) {
    $subject = "Your OTP Code";
    $message = "Your OTP code is $otp";
    $headers = "From: eventlanka10@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    mail($email, $subject, $message, $headers);
}

// Get the payable amount
$payableAmount = isset($_SESSION['payable_amount']) ? $_SESSION['payable_amount'] : 100;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_payment'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $zipCode = $_POST['zip_code'];
    $cardName = $_POST['card_name'];
    $cardNumber = $_POST['card_number'];
    $expMonth = $_POST['exp_month'];
    $expYear = $_POST['exp_year'];
    $cvv = $_POST['cvv'];

    // Generate and store OTP
    $otp = generateOTP();
    $encryptedOTP = encryptOTP($otp);

    // Prepare the SQL statement using PDO
    $stmt = $conn->prepare("INSERT INTO payment (first_name, last_name, email, city, zip_code, card_name, card_number, exp_month, exp_year, cvv, userId, amount, status, otp) 
                            VALUES (:first_name, :last_name, :email, :city, :zip_code, :card_name, :card_number, :exp_month, :exp_year, :cvv, :userId, :amount, 'Pending', :otp)");

    // Bind the parameters using PDO
    $stmt->bindValue(':first_name', $firstName);
    $stmt->bindValue(':last_name', $lastName);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':city', $city);
    $stmt->bindValue(':zip_code', $zipCode);
    $stmt->bindValue(':card_name', $cardName);
    $stmt->bindValue(':card_number', $cardNumber);
    $stmt->bindValue(':exp_month', $expMonth);
    $stmt->bindValue(':exp_year', $expYear);
    $stmt->bindValue(':cvv', $cvv);
    $stmt->bindValue(':userId', $userId); // Bind userId
    $stmt->bindValue(':amount', $payableAmount);
    $stmt->bindValue(':otp', $encryptedOTP);

    // Execute the prepared statement
    try {
        $stmt->execute();
        // Send OTP email
        sendOTPEmail($email, $otp);

        // Store the email in session for OTP verification
        $_SESSION['email'] = $email;
        header('Location: payment.php?verify=true');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Debugging
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];
    $email = $_SESSION['email'];

    // Retrieve the OTP from the database
    $stmt = $conn->prepare("SELECT otp FROM payment WHERE email = :email AND status = 'Pending'");
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $storedOtp = $stmt->fetchColumn();

    // Verify OTP
    if (password_verify($otp, $storedOtp)) {
        // Update payment status to 'Completed'
        $stmt = $conn->prepare("UPDATE payment SET status = 'Completed' WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        echo "Payment successful!";
    } else {
        echo "Invalid OTP.";
    }
} else {
    // Rest of your HTML rendering code for payment form...
}
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Verify OTP</title>
            <link rel="stylesheet" href="css/style.css">
        </head>
        <body>
            <div class="container">
                <h3 class="title">Verify OTP</h3>
                <form action="payment.php" method="POST">
                    <div class="inputBox">
                        <span>Enter OTP :</span>
                        <input type="text" name="otp" required>
                    </div>
                    <input type="submit" name="verify_otp" value="Verify" class="submit-btn">
                </form>
            </div>
        </body>
        </html>
      
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <title>Payment</title>
        </head>
        <body>
        <div class="container">
            <div class="navbar">
                <img src="images/1.png" class="logo" alt="Logo">
                <h1>Event Lanka</h1>
            </div>

            <form action="payment.php" method="POST">
                <div class="row">
                    <div class="col">
                        <h3 class="title">Summary and Invoices</h3>
                        <br>
                        <div class="inputBox">
                            <span>First Name :</span>
                            <input type="text" name="first_name" required>
                        </div>
                        <div class="inputBox">
                            <span>Last Name :</span>
                            <input type="text" name="last_name" required>
                        </div>
                        <div class="inputBox">
                            <span>E-mail :</span>
                            <input type="email" name="email" required>
                        </div>
                        <div class="inputBox">
                            <span>City :</span>
                            <input type="text" name="city" required>
                        </div>
                        <div class="flex">
                            <div class="inputBox">
                                <span>Zip Code :</span>
                                <input type="text" name="zip_code" required>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <h3 class="title">Payment</h3>
                        <div class="inputBox">
                            <span>Cards Accepted :</span>
                            <img src="images/2.png" alt="">
                        </div>
                        <div class="inputBox">
                            <span>Name on Card :</span>
                            <input type="text" name="card_name" required>
                        </div>
                        <div class="inputBox">
                            <span>Credit Card Number :</span>
                            <input type="text" name="card_number" required>
                        </div>
                        <div class="inputBox">
                            <span>Exp Month :</span>
                            <input type="text" name="exp_month" required>
                        </div>

                        <div class="flex">
                            <div class="inputBox">
                                <span>Exp Year :</span>
                                <input type="text" name="exp_year" required>
                            </div>
                            <div class="inputBox">
                                <span>CVV :</span>
                                <input type="text" name="cvv" required>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="submit" name="submit_payment" value="Submit" class="submit-btn">
            </form>
        </div>
        </body>
        </html>
        <?php
    

?>
