<?php
require "allRecipeCall.php";

header('Content-Type: application/json');

// Assuming $recipeCard contains the recipes
echo json_encode($recipeCard);
?>