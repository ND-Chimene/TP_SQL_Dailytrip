<?php

$host = 'localhost:3307';
$dbname = 'dailytrip_0';
$username = 'root';  // Remplacez par votre nom d'utilisateur
$password = '';      // Remplacez par votre mot de passe
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

function getItems($pdo, string $table)
{
    $query = "SELECT * FROM $table WHERE id BETWEEN 1 AND 10"; // Requête SQL
    $statement = $pdo->prepare($query); // Préparation de la requête
    $statement->execute(); // Exécuter la requête
    // print_r($statement->fetchAll(PDO::FETCH_ASSOC)); // Récupérer les résultats en tant que tableau associatif
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

$trips = getItems($pdo, 'trips');

?>

<div class="mb-44 flex justify-around gap-5 max-w-screen-lg mx-auto flex-wrap">
    <?php foreach ($trips as $trip) : ?>
        <div class="relative">
            <div class="absolute bg-gradient-to-b from-transparent from-60% to-neutral-900 w-full h-full rounded-lg">
                <div class="grid w-full h-full rounded-lg content-between p-2">
                    <button class="place-self-end rounded-full w-fit h-fit grid place-items-center p-1.5 hover:bg-red-600 transition ease-in-out text-white cursor-pointer">
                        <span class="material-symbols-outlined">favorite</span>
                    </button><!-- Favoris button-->
                    <div class="flex justify-between items-center">
                        <div class="text-white font-bold">
                            <p><?= $trip['title'] ?></p>
                            <div class="">
                                <span class="material-symbols-outlined text-yellow-500">star</span>
                                <span class="material-symbols-outlined text-yellow-500">star</span>
                                <span class="material-symbols-outlined text-yellow-500">star</span>
                                <span class="material-symbols-outlined">star</span>
                            </div>
                        </div><!--- Infos block -->
                        <div class="">
                            <a href="" # class="bg-white rounded-full w-fit h-fit grid place-items-center p-1.5 shadow-lg hover:bg-[#fba708] hover:-rotate-45 cursor-pointer">
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div><!-- Go to trip -->
                    </div>
                </div>
            </div>
            <img src="<?= $trip['cover'] ?>" alt="<?= $trip['title'] ?>" class="rounded-lg w-64 h-72 object-cover">
        </div>
    <?php endforeach; ?>
</div>