<?php
// Sprawdź, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Przypisz zmienne z danych formularza
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));

    // Sprawdź dane
    if (empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($message)) {
        // Ustaw kod odpowiedzi na 400 (złe żądanie) i wyjdź.
        http_response_code(400);
        echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // Ustaw adresata e-maila
    $recipient = "your-email@example.com";

    // Ustaw temat e-maila
    $subject = "New contact from $name";

    // Utwórz treść e-maila
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Utwórz nagłówki e-maila
    $email_headers = "From: $name <$email>";

    // Wyślij e-mail
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Ustaw kod odpowiedzi na 200 (OK)
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // Ustaw kod odpowiedzi na 500 (wewnętrzny błąd serwera)
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    // Nie jest to żądanie POST, ustaw kod odpowiedzi na 403 (zabronione)
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
