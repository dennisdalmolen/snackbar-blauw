<?php

session_start();

include "database.php";

if (isset($_POST['uname']) && isset($_POST['wachtwoord'])) {

    function validate($data)
    {

        $data = trim($data);

        $data = stripslashes($data);

        $data = htmlspecialchars($data);

        return $data;
    }

    $uname = validate($_POST['uname']);

    $pass = validate($_POST['wachtwoord']);

    if (empty($uname)) {

        header("Location: login.php?error=User Name is required");

        exit();
    } else if (empty($pass)) {

        header("Location: login.php?error=Password is required");

        exit();
    } else {

        $sql = "SELECT * FROM users WHERE email='$uname' AND wachtwoord='$pass'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['email'] === $uname && $row['wachtwoord'] === $pass) {

                echo "Logged in!";

                $_SESSION['email'] = $row['email'];

                $_SESSION['wachtwoord'] = $row['id'];

                header("Location: index.php");

                exit();
            } else {

                header("Location: login.php?error=Incorect User name or password");

                exit();
            }
        } else {

            header("Location: login.php?error=Incorect User name or password");

            exit();
        }
    }
} else {

    header("Location: gelukt.php");

    exit();
}
