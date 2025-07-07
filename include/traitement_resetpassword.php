<?php
session_start();

// Inclusion de PHPMailer
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';
require __DIR__ . '/../PHPMailer/Exception.php';
require_once("database.php"); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);

        if (!$email) {
            echo "Email invalide.";
            exit;
        }

        // Vérifier que l'utilisateur existe
        $query = $db->prepare("SELECT ID FROM utilisateurs WHERE email = ?");
        $query->execute([$email]);
        $user = $query->fetch();

        if ($user) {
            // Supprimer les anciens codes pour cet email
            $db->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

            // Générer un code à 6 chiffres
            $resetCode = random_int(100000, 999999);
            $expiration = date('Y-m-d H:i:s', strtotime('+5 minutes'));

            // Insérer le nouveau code
            $stmt = $db->prepare("INSERT INTO password_resets (email, reset_code, expiration) VALUES (?, ?, ?)");
            $stmt->execute([$email, $resetCode, $expiration]);

            // Envoi de l’e-mail via PHPMailer (Gmail SMTP)
            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'johnhoundji@gmail.com';
            $mail->Password = 'gazhsyekvcdbefks'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@gossipchat.local', 'GossipChat');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reinitialisation de mot de passe';
            $mail->Body = "
                <h3>Bonjour,</h3>
                <p>Voici votre code de reinitialisation :</p>
                <h2 style='color:blue;'>$resetCode</h2>
                <p>Ce code expirera dans 5 minutes.</p>
            ";

            try {
                $mail->send();
                $_SESSION['reset_email'] = $email; // Stocker l'email pour vérification
                header("Location: ../verifier_code.php"); // Redirige vers la page de vérification
                exit;
            } catch (\Exception $e) {
                echo "Erreur d'envoi : " . $mail->ErrorInfo;
            }
        } else {
            echo "Si cet e-mail existe, un code vous sera envoyé.";
        }
    }
}
