<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <h2>Všechny anketní otázky</h2>
    <a href="otazkyForm.php">zpět na zadávání otázek</a><br>

    <!--vytažení všech odpovědí k dané otázce z databáze a zobrazení-->
    <?php

    if(isset($_GET['id'])) {
        if (!($con = mysqli_connect("localhost", "www", "heslo", "ankety"))) {
            die("Nelze se připojit k databázovému serveru!</body></html>");
        }
        mysqli_query($con, "SET NAMES 'utf8'");
        mysqli_query(
            $con,
            "UPDATE odpovedi SET hlasu = hlasu + 1 WHERE id_odpoved = " . addslashes($_GET['id']) 
            );
    }

    if (!($con = mysqli_connect("localhost", "www", "heslo", "ankety"))) {
        die("Nelze se připojit k databázovému serveru!</body></html>");
    }
    mysqli_query($con, "SET NAMES 'utf8'");
    $vysledekOt = mysqli_query($con, "SELECT * FROM otazky");

    while ($radekOt = mysqli_fetch_array($vysledekOt)) {
        echo ("<h3>" . htmlspecialchars($radekOt["otazka_text"]) . "</h3>");
        $ot = $radekOt["id_otazka"];
        $vysledekOdp = mysqli_query($con, "SELECT * FROM odpovedi WHERE id_otazka=$ot");
        while ($radekOdp = mysqli_fetch_array($vysledekOdp)) {
            $idOdp = $radekOdp["id_odpoved"]; 
            echo "<p>";
            echo htmlspecialchars($radekOdp["odpoved_text"]); #text odpovědi
            echo " (<a href='otazkyAOdpovedi.php?id=" . $idOdp . "'>" . htmlspecialchars($radekOdp["hlasu"]) . " hlasů)</a>"; #počet hlasů s odkazem
            echo "</p>";
        }
        mysqli_free_result($vysledekOdp);
    }
    ?>

</body>
</html>