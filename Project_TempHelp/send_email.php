<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $compensation = trim($_POST["compensation"]);
    $description = trim($_POST["description"]);

    // Check that data was sent to the mailer.
    if (empty($name) || empty($compensation) || empty($description) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // Set the recipient email address.
    $recipient = "shlee020612@gmail.com";

    // Set the email subject.
    $subject = "New Project Request from $name";

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Compensation: $compensation\n";
    $email_content .= "Project Description:\n$description\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "<script>alert('Your Project Request Has Been Successfully Submitted!'); window.location.href = 'index.html';</script>";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "<script>alert('Oops! Something went wrong, and we couldn\'t send your request. Please try again.'); window.location.href = 'index.html';</script>";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "<script>alert('There was a problem with your submission, please try again.'); window.location.href = 'index.html';</script>";
}
?>
