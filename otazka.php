<!DOCTYPE html>
<html lang="cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Detail otázky</title>
</head>

<body>

    <?php
    /*vytažení příslušné otázky z databáze*/
    if (isset($_GET["id"])) {

        if (!($con = mysqli_connect("localhost", "www", "heslo", "ankety"))) {
            die("Nelze se připojit k databázovému serveru!</body></html>");
        }

        mysqli_query($con, "SET NAMES 'utf8'");
        $id = addslashes($_GET["id"]);
        echo ("Otázka č. " . $id);
        if (!($vysledek = mysqli_query($con, "SELECT otazka_text FROM otazky WHERE id_otazka='$id'"))) {
            die("Otázky nelze zobrazit.</body></html>");
        }

        while ($radek = mysqli_fetch_array($vysledek)) {
            echo ("<p>" . htmlspecialchars($radek["otazka_text"]) . "</p>");
        }
        mysqli_free_result($vysledek);
        mysqli_close($con);
    }

    /*<!--vložení nové odpovědi do databáze-->*/
        if (isset($_POST["answer"])) {
            if (!($con = mysqli_connect("localhost", "www", "heslo", "ankety"))) {
                die("Nelze se připojit k databázovému serveru!</body></html>");
            }
            mysqli_query($con, "SET NAMES 'utf8'");
            if (mysqli_query(
                $con,
                "INSERT INTO odpovedi(id_otazka, odpoved_text) VALUES('" .
                    addslashes($_POST["question_id"]) . "', '" .
                    addslashes($_POST["answer"]) . "')"
            )) {
                echo "Odpověď byla uložena.";
            } else {
                echo "Vložení odpovědi se nezdařilo. " . mysqli_error($con);
            }
            mysqli_close($con);
        }
    ?>

    <!--vytažení všech odpovědí k dané otázce z databáze a zobrazení-->
    <?php
    if (!($con = mysqli_connect("localhost", "www", "heslo", "ankety"))) {
        die("Nelze se připojit k databázovému serveru!</body></html>");
    }
    mysqli_query($con, "SET NAMES 'utf8'");
    if (!($vysledek2 = mysqli_query($con, "SELECT * FROM odpovedi WHERE id_otazka=$id"))) {
        die("Otázky nelze zobrazit.</body></html>");
    }

    while ($radek2 = mysqli_fetch_array($vysledek2)) {
        echo ("<p>" . htmlspecialchars($radek2["odpoved_text"]) . "</p>");
    }

    mysqli_free_result($vysledek2);
    mysqli_close($con);
    ?>

    <!--formulář pro zadání nové odpovědi-->
    <h3>Nová odpověď</h3>
    <form action="otazka.php?id=<?php echo htmlspecialchars($_GET["id"])?>" method="POST">
        <textarea name="answer" id="" cols="50" rows="5" placeholder="zde napište novou odpověď na otázku"></textarea><br>
        <input type="hidden" name="question_id"  value='<?php echo htmlspecialchars($_GET["id"])?>'>
        <input type="submit" value="Přidat odpověď">
    </form>
    <br><br>

    <a href="otazkyAOdpovedi.php">ZOBRAZIT VŠECHNY OTÁZKY A HLASOVAT</a>
</body>

</html>