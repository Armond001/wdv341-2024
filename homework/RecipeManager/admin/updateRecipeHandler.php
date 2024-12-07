<?php
session_start();
if (!isset($_SESSION['validUser'])) {
    header('Location: login.php');
    exit;
}

require "../dbConnect/dbConnect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $recipeName = $_POST['recipeName'];
    $ingredients = $_POST['ingredients'];
    $description = $_POST['description'];

    try {
        $sql = "UPDATE recipes 
                SET recipeName = :recipeName, ingredients = :ingredients, description = :description 
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':recipeName', $recipeName, PDO::PARAM_STR);
        $stmt->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['successMessage'] = "Recipe updated successfully!";
        header('Location: allRecipePage.php');
    } catch (PDOException $e) {
        $_SESSION['errorMessage'] = "Error updating recipe: " . $e->getMessage();
        header("Location: updateRecipe.php?recipeID=$id");
    }
}
?>
