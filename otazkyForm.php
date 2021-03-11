<!DOCTYPE html>
<html lang="cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Anketní otázky</title>
</head>

<body>
    <h1>Anketní otázky</h1>

    <!--vložení nové otázky do databáze-->
    <?php
    if (isset($_POST["question"])) { # zajišťuje, aby to při loadu stránky nehodilo error

        if (!($con = mysqli_connect("localhost", "www", "heslo", "ankety"))) {
            die("Nelze se připojit k databázovému serveru!</body></html>");
        }
        mysqli_query($con, "SET NAMES 'utf8'");
        if (mysqli_query(
            $con,
            "INSERT INTO otazky(otazka_text) VALUES('" .
                addslashes($_POST["question"]) . "')"
        )) {
            echo "Otázka byla vložena.";
        } else {
            echo "Vložení otázky se nezdařilo. " . mysqli_error($con);
        }
        mysqli_close($con);
    }
    ?>

    <h2>Existující otázky</h2>

    <!--zobrazení všech stávajících otázek z databáze-->
    <?php
    if (!($con = mysqli_connect("localhost", "www", "heslo", "ankety"))) {
        die("Nelze se připojit k databázovému serveru!</body></html>");
    }
    mysqli_query($con, "SET NAMES 'utf8'");
    if (!($vysledek = mysqli_query($con, "SELECT id_otazka, otazka_text FROM otazky"))) {
        die("Otázky nelze zobrazit.</body></html>");
    }

    while ($radek = mysqli_fetch_array($vysledek)) {
        $id = $radek["id_otazka"];
        echo ("<p>" . htmlspecialchars($radek["otazka_text"]) . " <a href='otazka.php?id=" . $id . "'>zobrazit</a></p>");
    }

    mysqli_free_result($vysledek);
    mysqli_close($con);
    ?>

    <h2>Nová otázka</h2>
    <form action="otazkyForm.php" method="POST">
        <textarea name="question" id="" cols="50" rows="5" placeholder="zde napište novou anketní otázku"></textarea><br>
        <input type="submit" value="Vytvořit novou anketu">
    </form>
    <br><br>

    <a href="otazkyAOdpovedi.php">ZOBRAZIT VŠECHNY OTÁZKY A HLASOVAT</a>
    
</body>

</html>