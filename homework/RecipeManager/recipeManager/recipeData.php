<?php




if (!isset($_GET["recipeID"])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(["error" => "Recipe ID not provided"]);
    exit;
}

$recipeID = $_GET["recipeID"];

require "../dbConnect/dbConnect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT id, recipeName, cookingTime, ingredients, image, description, servings, difficulty, instructions 
        FROM recipes WHERE id = :recipeID";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':recipeID', $recipeID);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

if ($stmt->rowCount() == 0) {
    echo json_encode(["error" => "No results found"]);
    exit;
}

$recipeCard = $stmt->fetch();

header('Content-Type: application/json');
echo json_encode($recipeCard);
