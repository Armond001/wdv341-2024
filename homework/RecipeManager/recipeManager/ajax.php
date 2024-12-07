<?php
require "recipeAsideAjax.php";
require "featuredRecipes.php";
require "featuredRecipes2.php";

header('Content-Type: application/json');

$response = [
    'recipeAsideData' => $recipeCard,
    'recipeFeatureData1' => $recipeFeatureCard,
    'recipeFeatureData2' => $recipeCard2,
];

echo json_encode($response);
?>