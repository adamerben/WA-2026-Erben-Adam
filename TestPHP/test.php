<?php
    $name = "";
    $age = "";
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["my_name"];
        $age = $_POST["age"];
        if ($name == "Tom") {
            $message = "Ahoj Tome";
        } else {
            $message = "Neznám tě";
        }
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Test Formuláře</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis amet vitae, facere delectus dolorem quam nesciunt dolore praesentium incidunt eius aperiam mollitia debitis expedita magnam reiciendis, maxime distinctio facilis nobis!</p>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officia, distinctio sed ad vitae illum quidem culpa atque recusandae? Saepe odio ipsa, numquam consectetur unde cum error sint at asperiores harum.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci placeat debitis voluptatum libero explicabo recusandae reiciendis, voluptates quia nisi eligendi sit minima magnam deserunt quae. Totam consectetur ullam enim rem?</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab quis earum tenetur debitis consequuntur odio asperiores magni? Magnam tempora nemo ut, deserunt saepe eius, mollitia ab iusto in suscipit molestias.</p>
    <form method="post">
        <input type="text" name="my_name" placeholder="Zadejte jméno">
        <input type="number" name="age" placeholder="Zadejte věk">
        <button type="submit">Odeslat</button>
    </form>
    <p>
        <?php 
        echo "Výstup: "; 
        echo $message; 
        ?>
    </p>
    <p>
        <?php 
        echo "Tvůj věk: ";
        echo $age;
        ?>
    </p>
</body>
</html>