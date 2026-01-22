<?php
session_start();
include 'config.php';


if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1){
    header("Location: Login.php");
    exit;
}

$profile_pic = 'img/member.png'; 

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT profile_pic FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user_pic = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user_pic && $user_pic['profile_pic']){
        $profile_pic = htmlspecialchars($user_pic['profile_pic']);
    }
}

$userQuery = $conn->prepare("SELECT id, name, username, email, is_admin, profile_pic FROM users ORDER BY id ASC");
$userQuery->execute();
$users = $userQuery->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Menaxho Perdoruesit | Admin Dashboard</title>

<style>

.back-btn {
    display: inline-block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #ffffff;
    color: #2e7d32;
    text-decoration: none;
    font-weight: bold;
    border-radius: 8px;
    border: 2px solid #2e7d32;
    transition: 0.3s;
    text-align: center;
}
.back-btn:hover {
    background-color: #2e7d32;
    color: white;
}

.user-table {
    width: 95%;
    max-width: 1200px;
    margin: 30px auto 50px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.user-table th, .user-table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

.user-table th {
    background: #2e7d32;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.user-table tr:hover {
    background: #d5f5e3;
}

.user-table a.btn {
    padding: 6px 12px;
    border-radius: 5px;
    color: #fff;
    text-decoration: none;
    margin: 0 2px;
    display: inline-block;
    transition: 0.3s;
    font-weight: bold;
}

.user-table .edit {
    background: #2196F3;
}

.user-table .edit:hover {
    background: #0b7dda;
}

.user-table .delete {
    background: #f44336;
}

.user-table .delete:hover {
    background: #da190b;
}

@media (max-width: 768px) {
    .user-table th, .user-table td {
        font-size: 14px;
        padding: 8px;
    }

    .back-btn {
        padding: 8px 16px;
        font-size: 14px;
    }
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 25px 30px;
    border-radius: 12px;
    max-width: 400px;
    text-align: center;
    position: relative;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    animation: popIn 0.3s ease;
}

.modal-icon {
    font-size: 50px;
    margin-bottom: 15px;
}

.modal h3 {
    color: #c0392b;
    margin-bottom: 10px;
}

.modal p {
    margin-bottom: 20px;
    color: #333;
}

.modal-buttons {
    display: flex;
    justify-content: center;
    gap: 12px;
}

.modal .btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
    cursor: pointer;
}

.modal .btn.delete {
    background-color: #f44336;
    color: white;
}

.modal .btn.delete:hover {
    background-color: #da190b;
}

.modal .btn.cancel {
    background-color: green;
    color: white;
    border: none;
}

.modal .btn.cancel:hover {
    background-color: #95a5a6;
}

.close {
    position: absolute;
    top: 12px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #999;
    transition: 0.3s;
}

.close:hover {
    color: #333;
}


.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: #fff;
    width: 400px;
    margin: 15% auto;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

.modal-content h3 {
    color: red;
}

.modal-content .btn {
    background: #2e7d32;
    color: #fff;
    border: none;
    padding: 8px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.modal-content .btn:hover {
    background: #1b5e20;
}

.user-table img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

</style>

</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">🌿 EkoKosova</div>

        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>

        <ul class="nav-links">
            <li><a href="index.php">Ballina</a></li>
            <li><a href="about.php">Rreth Nesh</a></li>
            <li><a href="Reports.php">Raportimet</a></li>
            <li><a href="contact.php">Kontakti</a></li>
            <li><a href="quotes.php">Thenie</a></li>
        </ul>

        <div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-icon">🗑️</div>
        <h3>Jeni te sigurt?</h3>
        <p>Po perpiqeni te fshini kete perdorues. Ky veprim nuk mund te kthehet.</p>
        <div class="modal-buttons">
            <a href="#" id="confirmDelete" class="btn delete">Fshij</a>
            <button class="btn cancel">Anulo</button>
        </div>
    </div>
</div>

        <div class="nav-buttons">
            <?php if(isset($_SESSION['user_id'])): ?>
                <span class="welcome">
                    <span style="color:white;">Miresevjen,</span>
                    <strong style="color:white;"><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                </span>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="profile-link">
                        <img src="<?= $profile_pic ?>" alt="Profili Im" class="nav-profile-pic">
                    </a>
                <?php endif; ?>

                <?php if($_SESSION['is_admin'] == 1): ?>
                    <a href="admin_dashboard.php"style=" margin-left:10px;padding: 10px 20px;background-color: green;color: white;text-decoration: none;border-radius: 8px;transition: 0.3s;">Dashboard</a>
                <?php endif; ?>

                <form action="Logout.php" method="POST" class="translate" style="display:inline; margin-left:5px;">
                    <button type="submit" class="translate">
                        <img src="img/logout.png" class="logoutsymbol" style="width:20px;">
                    </button>
                </form>

                <button class="translate" style="margin-left:5px;">🌐</button>

            <?php else: ?>
    
                <button class="login">
                    <a href="Login.php" style="text-decoration:none;color:white;">Kyçu</a>
                </button>

                <button class="signup">
                    <a href="Signup.php" style="text-decoration:none;color:white;">Regjistrohu</a>
                </button>

                <button class="translate">🌐</button>
            <?php endif; ?>
        </div>
    </nav>
</header>

<h2 style="text-align:center">👥 Menaxhimi i Perdoruesve</h2>
<table class="user-table">
    <tr>
        <th>ID</th>
        <th>Foto</th> <!-- Kolona e re -->
        <th>Emri</th>
        <th>Username</th>
        <th>Email</th>
        <th>Roli</th>
        <th>Veprime</th>
    </tr>

    <?php foreach($users as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td>
            <img src="<?= $row['profile_pic'] ? htmlspecialchars($row['profile_pic']) : 'img/default-avatar.png' ?>" 
                 alt="Foto Profili" style="width:40px;height:40px;border-radius:50%;">
        </td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= $row['is_admin'] ? 'Admin' : 'User' ?></td>
        <td>
            <a class="btn edit" href="edit_users.php?id=<?= $row['id'] ?>">✏️</a>
            <a class="btn delete" href="delete_users.php?id=<?= $row['id'] ?>" data-id="<?= $row['id'] ?>">🗑️</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-about">
            <h3 class="logo">🌿 EkoKosova</h3>
            <p>“Mbrojmë Natyrën, Përmirësojmë Kosovën”</p>
        </div>
        <div class="footer-links">
            <h4>Navigimi</h4>
            <ul>
                <li><a href="index.php">Ballina</a></li>
                <li><a href="about.php">Rreth Nesh</a></li>
                <li><a href="Reports.php">Raportimet</a></li>
                <li><a href="contact.php">Kontakti</a></li>
                <li><a href="quotes.php">Thenie</a></li>
            </ul>
        </div>
        
        <div id="selfDeleteModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>⚠️ Veprim i ndaluar</h3>
                <p>Nuk mund ta fshini llogarinë tuaj.</p>
                <button class="btn cancel">OK</button>
            </div>
        </div>
        <div class="footer-contact">
            <h4>Kontakti</h4>
            <p>Email: info@ekokosova.com</p>
            <p>Tel: +383 44 123 456</p>
            <p>Prishtinë, Kosovë</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 EkoKosova. Të gjitha të drejtat e rezervuara.</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');
    const confirmBtn = document.getElementById('confirmDelete');
    const cancelBtn = deleteModal.querySelector('.btn.cancel');
    const closeBtn = deleteModal.querySelector('.close');

    const selfModal = document.getElementById('selfDeleteModal');
    const selfClose = selfModal.querySelector('.close');
    const selfCancel = selfModal.querySelector('.btn.cancel');

    const currentUserId = <?= $_SESSION['user_id'] ?>;

    const deleteLinks = document.querySelectorAll('.user-table .delete');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const userId = parseInt(this.dataset.id);

            if(userId === currentUserId) {
                // kjo perdoret kur tenton useri ta fshij veten qe shfaq popup 
                selfModal.style.display = 'block';
            } else {
                // kjo ndodh kur tenton ta fshij tjetrin
                const href = this.getAttribute('href'); 
                confirmBtn.setAttribute('href', href);
                deleteModal.style.display = 'block';
            }
        });
    });

    // pjesa e fshirjes normal
    cancelBtn.addEventListener('click', () => deleteModal.style.display = 'none');
    closeBtn.addEventListener('click', () => deleteModal.style.display = 'none');

    // pjesa e fshirjes se vetes
    selfCancel.addEventListener('click', () => selfModal.style.display = 'none');
    selfClose.addEventListener('click', () => selfModal.style.display = 'none');

    // mbyllja e popup
    window.addEventListener('click', (e) => {
        if(e.target === deleteModal) deleteModal.style.display = 'none';
        if(e.target === selfModal) selfModal.style.display = 'none';
    });
});

</script>
</body>
</html>
