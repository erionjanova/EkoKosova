<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: Login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_contacts.php");
    exit;
}

$id = (int) $_GET['id'];
$error_message = "";

$editContacts = $conn->prepare("SELECT * FROM contacts WHERE id = ?");
$editContacts->execute([$id]);
$contact = $editContacts->fetch(PDO::FETCH_ASSOC);

if (!$contact) {
    die("Kontakti nuk ekziston.");
}

if (isset($_POST['submit'])) {
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $subject   = trim($_POST['subject']);
    $message   = trim($_POST['message']);

    if (empty($full_name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = "⚠️ Ju lutem plotësoni të gjitha fushat!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "⚠️ Email-i nuk është valid!";
    } else {
        $update = $conn->prepare("
            UPDATE contacts 
            SET full_name=?, email=?, subject=?, message=? 
            WHERE id=?
        ");
        $update->execute([$full_name, $email, $subject, $message, $id]);

        header("Location: manage_contacts.php?updated=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="UTF-8">
<title>Edit Contact | Dashboard</title>
<link rel="stylesheet" href="style.css">

<style>
.edit-container {
    max-width: 600px;
    margin: 50px auto;
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.edit-container h2 {
    color: #2e7d32;
    text-align: center;
    margin-bottom: 25px;
}

.edit-container label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
    color: #2e7d32;
}

.edit-container input,
.edit-container textarea {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border-radius: 8px;
    border: 1px solid #bfbfbf;
    font-size: 15px;
}

.edit-container textarea {
    resize: vertical;
}

.edit-container input[type=submit] {
    margin-top: 25px;
    width: 100%;
    padding: 12px;
    background: #2e7d32;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

.edit-container input[type=submit]:hover {
    background: #1b5e20;
}

.back-link {
    display: inline-block;
    margin-bottom: 20px;
    color: #2e7d32;
    font-weight: bold;
    text-decoration: none;
}

.error-message {
    background: #f8d7da;
    color: #842029;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
    text-align: center;
}
</style>
</head>
<body>
<main class="edit-container">

<a href="manage_contacts.php" class="back-link">⬅ Kthehu te Kontaktet</a>
<h2>✏️ Edit Contact</h2>

<?php if ($error_message): ?>
    <div class="error-message"><?= $error_message ?></div>
<?php endif; ?>

<form method="POST">

    <label>Emri i plotë</label>
    <input type="text" name="full_name" value="<?= htmlspecialchars($contact['full_name']) ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($contact['email']) ?>">

    <label>Subjekti</label>
    <input type="text" name="subject" value="<?= htmlspecialchars($contact['subject']) ?>">

    <label>Mesazhi</label>
    <textarea name="message" rows="5"><?= htmlspecialchars($contact['message']) ?></textarea>

    <input type="submit" name="submit" value="Ruaj Ndryshimet">
</form>

</main>
</body>
</html>
