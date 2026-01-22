<?php
session_start();
include_once('config.php');

if(isset($_POST['submit'])){
            //injoron hapsirat
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kontrollo fushat e zbrazeta
    if(empty($name) || empty($username) || empty($email) || empty($password) || empty($confirm_password)){ 
        $_SESSION['error_message'] = "⚠️ Plotesoni te gjitha fushat.";
        header("Location: SignUp.php");
        exit;
    } elseif($password !== $confirm_password){
        $_SESSION['error_message'] = "⚠️ Fjalekalimet nuk perputhen.";
        header("Location: SignUp.php");
        exit;
    }

    if (
        strlen($password) < 6 ||
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[0-9]/', $password) ||  
        !preg_match('/[\W_]/', $password)      
    ) {
        $_SESSION['error_message'] = "⚠️ Fjalekalimi duhet te kete minimum 6 karaktere, te pakten nje shkronje te madhe, nje numer dhe nje simbol.";

        header("Location: SignUp.php");
        exit;
    }

        // kontrollojme nese emaili eshte shkruar i plote pa mungese te simbolit @ dhe pjeses mbrapa @gmail.com psh
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = "⚠️ Email-i duhet te kete format te sakte.";
            header("Location: SignUp.php");
            exit;
        }


    // Kontrollo username/email nese ekziston dhe shfaq popup
    $checkSql = "SELECT id FROM users WHERE username = :username OR email = :email";
    $userQuery = $conn->prepare($checkSql);
    $userQuery->bindParam(':username', $username);
    $userQuery->bindParam(':email', $email);
    $userQuery->execute();

    if($userQuery->rowCount() > 0){ // nese ka nje user qe ekziston me te njejtin username ose email nuk na lejon sistemi
        $_SESSION['error_message'] = "⚠️ Username ose email ekziston tashme.";
        header("Location: SignUp.php");
        exit;
    }

    // Hash i fjalekalimit
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $is_admin = 0;

    // Perpunimi i fotos se profilit
    $profile_pic = 'img/member.png'; // default
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $allowed_types = ['image/jpeg','image/png','image/gif','image/avif']; // formin nje list me tipin e fotove te lejuara per upload

        if (in_array($_FILES['profile_pic']['type'], $allowed_types)) {
            $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION); // e merr edhe extension e file psh .png , .jpg.

            $filename = 'img/profile_' . $user_id . '_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filename); // tmp_name perdoret per me rujt files ne php
            $profile_pic = $filename;
        }
    }

    

    // Insert ne DB
    $sql = "INSERT INTO users (name, email, username, password, is_admin, profile_pic) 
            VALUES (:name, :email, :username, :password, :is_admin, :profile_pic)";
    $userQuery = $conn->prepare($sql);
    $userQuery->bindParam(':name', $name);
    $userQuery->bindParam(':email', $email);
    $userQuery->bindParam(':username', $username);
    $userQuery->bindParam(':password', $hashedPassword);
    $userQuery->bindParam(':is_admin', $is_admin);
    $userQuery->bindParam(':profile_pic', $profile_pic);

    if($userQuery->execute()){
        $user_id = $conn->lastInsertId(); 
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = $is_admin;

        $_SESSION['success_message'] = "✅ Regjistrimi u krye me sukses!";
        header("Location: Login.php"); 
        exit;
    } else {
        $_SESSION['error_message'] = "⚠️ Ndodhi nje gabim gjate regjistrimit.";
        header("Location: SignUp.php");
        exit;
    }
}
?>
