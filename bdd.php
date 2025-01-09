<?php

// Informations de connexion à la base de données
$host = 'localhost:3307';
$user = 'root';
$password = '';
$database = 'dailytrip_0';

try {
    // Connexion au serveur MySQL sans sélectionner de base de données
    $conn = new PDO("mysql:host=$host", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Créer la base de données si elle n'existe pas
    $sql = "CREATE DATABASE IF NOT EXISTS `$database` DEFAULT CHARACTER SET = 'utf8mb4'";
    $conn->exec($sql);
    // echo "Base de données '$database' créée avec succès.\n";

    // Se connecter à la base de données créée
    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Définir le moteur InnoDB pour la création des tables
    $engine = 'ENGINE = InnoDB';

    // Création des tables
    $tables = [
        // TODO: Ajoutez vos requêtes SQL de création de tables ici
        "CREATE TABLE `category` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `image` VARCHAR(255) NOT NULL
        );",

        "CREATE TABLE `localisation` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `start` VARCHAR(255) NOT NULL,
            `finish` VARCHAR(255) NOT NULL,
            `distance` DECIMAL(10, 2) NOT NULL,
            `duration` TIME NOT NULL
        );",

        "CREATE TABLE `trips` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `ref` VARCHAR(255) NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT NULL,
            `cover` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `localisation_id` INT NOT NULL,
            `category_id` INT NOT NULL,
            `status` TINYINT(1) NOT NULL
        );",

        "CREATE TABLE `poi` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `point` VARCHAR(255) NOT NULL,
            `localisation_id` INT NOT NULL
        );",

        "CREATE TABLE `rating` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `note` INT NOT NULL,
            `ip_address` VARCHAR(255) NOT NULL,
            `trip_id` INT NOT NULL
        );",

        "CREATE TABLE `review` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `fullname` VARCHAR(255) NOT NULL,
            `content` TEXT,
            `email` VARCHAR(255) NOT NULL,
            `trip_id` INT NOT NULL
        );"
    ];

    // Exécution de la création des tables
    foreach ($tables as $tableSql) {
        try {
            $conn->exec($tableSql);
            // echo "Table créée avec succès.\n";
        } catch (PDOException $e) {
            echo "Erreur lors de la création de la table : " . $e->getMessage() . "\n";
        }
    }

    // Ajout des clés étrangères
    $constraints = [
        // TODO: Ajoutez vos requêtes SQL de contraintes ici
        "ALTER TABLE trips ADD CONSTRAINT trips_localisation_id FOREIGN KEY (localisation_id) REFERENCES localisation(id);",
        "ALTER TABLE trips ADD CONSTRAINT trips_category_id FOREIGN KEY (category_id) REFERENCES category(id);",
        "ALTER TABLE poi ADD CONSTRAINT poi_localisation_id FOREIGN KEY (localisation_id) REFERENCES localisation(id)",
        "ALTER TABLE rating ADD CONSTRAINT rating_trip_id FOREIGN KEY (trip_id) REFERENCES trips(id)",
        "ALTER TABLE review ADD CONSTRAINT review_trip_id FOREIGN KEY (trip_id) REFERENCES trips(id)"
    ];

    // Exécution des contraintes de clés étrangères
    foreach ($constraints as $constraintSql) {
        try {
            $conn->exec($constraintSql);
            // echo "Contrainte de clé étrangère ajoutée avec succès.\n";
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la contrainte : " . $e->getMessage() . "\n";
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
    exit;
} finally {
    // Fermer la connexion
    $conn = null;
}
