<?php

$favAnimals = (isset($_GET['favAnimals']) && !empty($_GET['favAnimals']))? $_GET['favAnimals'] : [];

foreach ($favAnimals as $animal){
    echo "$animal";
}
?>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
    <label>Quelles espèces animaux aimez-vous ?</label><br />
    <label><input type="checkbox" name="favAnimals[]" value="chien" /> les chiens</label>
    <label><input type="checkbox" name="favAnimals[]" value="chat" /> les chats</label>
    <label><input type="checkbox" name="favAnimals[]" value="oiseau" /> les oiseaux</label>
    <label><input type="checkbox" name="favAnimals[]" value="cheval" /> les chevaux (bourrins)</label>
    <label><input type="checkbox" name="favAnimals[]" value="poisson" /> les poissons</label><br />
    <button type="submit">submit</button>
</form>
