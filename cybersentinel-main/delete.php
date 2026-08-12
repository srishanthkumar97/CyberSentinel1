<?php

define('SENTINEL_WEB_PAGE_TO_ROOT', ''); // Adjust as needed
require_once SENTINEL_WEB_PAGE_TO_ROOT . 'sentinel/includes/sentinelPage.inc.php';

sentinelPageStartup(array());
sentinelDatabaseConnect();

$messagesHtml = messagesPopAllToHtml();

// Assuming you have a function to get the current user
$currentuser = sentinelCurrentUser();

// Display the confirmation form
echo "<!DOCTYPE html>
<html lang=\"en-GB\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    <title>Delete User :: Cyber Sentinel</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />
</head>
<body class=\"delete-page-body\">
    <main class=\"delete-page\">
        <div class=\"delete-card\">
            <div class=\"delete-card__header\">
                <span class=\"delete-card__tag\">Danger Zone</span>
                <h1>Delete User</h1>
                <p>Are you sure you want to delete the current user <strong>{$currentuser}</strong>? This action cannot be undone.</p>
            </div>

            <form action=\"delete.php\" method=\"post\" class=\"delete-form\">
                <label for=\"password\">Enter Password</label>
                <input type=\"password\" id=\"password\" name=\"password\" autocomplete=\"off\" required />

                <div class=\"delete-actions\">
                    <button type=\"submit\" name=\"delete_confirm\" class=\"delete-btn delete-btn--danger\">Yes, Delete</button>
                    <a href=\"/cybersentinel/index.php\" class=\"delete-btn delete-btn--secondary\">Cancel</a>
                </div>
            </form>

            <div class=\"delete-message\">
                {$messagesHtml}
            </div>
        </div>
    </main>
</body>
</html>";

// Function to validate the password
function validatePassword($currentuser, $enteredPassword) {
    //$enteredPassword = password_hash($enteredPassword, PASSWORD_DEFAULT); // More secure way.
    $enteredPassword = stripslashes($enteredPassword);
    $enteredPassword = md5($enteredPassword); // Less secure way. (don't use MD5 hashing)

    // Password validation logic
    $query = "SELECT password FROM users WHERE user = '{$currentuser}'";
    mysqli_select_db($GLOBALS["___mysqli_ston"], "sentinel");
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

    if ($result && mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        // Check against the stored hashed password in the database
        if ($hashedPassword === $enteredPassword) {
            return true;
        }
        else {
            return false;
        }
    }
    sentinelMessagePush("There is an error with the username");
    return false;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_confirm'])) {
        $enteredPassword = $_POST['password'];
        
        // Validate the password
        if (validatePassword($currentuser, $enteredPassword)) {
            // Password is correct, proceed with deletion
            $deleteuser = "DELETE FROM users WHERE user = '{$currentuser}'";
            $result = mysqli_query($GLOBALS["___mysqli_ston"], $deleteuser);

            if ($result) {
                sentinelMessagePush("User '{$currentuser}' deleted successfully.");
                sentinelRedirect(SENTINEL_WEB_PAGE_TO_ROOT . 'login.php'); // Redirect to the desired page
            } else {
                sentinelMessagePush("Error deleting user '{$currentuser}': " . mysqli_error($GLOBALS["___mysqli_ston"]));
            }
        } else {
            sentinelMessagePush("Incorrect password. User not deleted.");
            sentinelPageReload();
        }
    }
}
?>