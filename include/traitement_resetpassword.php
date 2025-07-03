<?php
session_start(); 

require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';
require __DIR__ . '/../PHPMailer/Exception.php';
require_once("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (isset($_POST['email'])) { 
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL); 
        if (!$email) { 
            echo "email invalid."; 
            exit;
        } 

        $query = $db->prepare("SELECT ID FROM utilisateurs WHERE email=?");
        $query->execute([$email]);
        $user = $query->fetch();

        if ($user) {
            $resetCode = random_int(100000, 999999); 
            $expiration = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $stmt = $db->prepare("INSERT INTO password_resets (email, reset_code, expiration) VALUES (?, ?, ?)");
            $stmt->execute([$email, $resetCode, $expiration]);

            $mail = new \PHPMailer\PHPMailer\PHPMailer(); 
            $mail->isSMTP();
            $mail->Host = 'localhost';
            $mail->Port = 1025;
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;

            $mail->setFrom('no-reply@gossipchat.local', 'GossipChat');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Reinitialisation de mot de passe';
            $mail->Body = "
                <h3>Bonjour,</h3>
                <p>Voici votre code de réinitialisation :</p>
                <h2 style='color:blue;'>$resetCode</h2>
                <p>Ce code expirera dans 5 minutes.</p>
            ";

            try {
                $mail->send();

                // Stocke l'email en session pour préremplir sur verifier_code.php
                $_SESSION['reset_email'] = $email;

                // Redirection vers la page de saisie du code
                header("Location:../verifier_code.php");
                exit;

            } catch (\Exception $e) {
                echo "Erreur lors de l'envoi du mail : " . $mail->ErrorInfo;
            }
        } else {
            echo "Si cet e-mail existe, un code vous sera envoyé.";
        }
    }
}
