<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recipe Project</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../StyleSheets/recipePage.css">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/3bt0HR6G4G6z4U9ykzAOkncKTtCpQQ/+/hSlrx"
        crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            const recipeID = new URLSearchParams(window.location.search).get("recipeID");
            if (!recipeID) {
                alert("Recipe ID not provided!");
                return;
            }

            // Fetch recipe data using AJAX
            $.ajax({
                url: `recipeData.php?recipeID=${recipeID}`,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    const recipeElement = createRecipeTable(data);
                    $("main").append(recipeElement);
                },
                error: function (xhr) {
                    alert("An error occurred: " + xhr.responseText);
                }
            });

            function createRecipeTable(recipe) {
                const mainRecipeDiv = $("<div>").addClass("recipeContainer");
                const recipeImg = $("<img>").addClass("recipeIMG").attr("src", `../Images/${recipe.image}`);
                const recipeName = $("<h2>").text(recipe.recipeName);
                const recipeDescription = $("<p>").text(recipe.description);
                const recipeCookingTime = $("<h2>").text("Cooking Time").append($("<p>").text(recipe.cookingTime));
                const recipeDifficulty = $("<h2>").text("Difficulty").append($("<p>").text(recipe.difficulty));
                const servingsDiv = createServingsSection(recipe.servings, recipe.ingredients);
                const ingredientsDiv = createIngredientsSection(recipe.ingredients);
                const directionsDiv = createDirectionsSection(recipe.instructions);

                mainRecipeDiv.append(
                    recipeImg,
                    recipeName,
                    recipeDescription,
                    recipeCookingTime,
                    recipeDifficulty,
                    servingsDiv,
                    ingredientsDiv,
                    directionsDiv
                );

                return mainRecipeDiv;
            }

            function createServingsSection(servings, ingredients) {
                const servingsDiv = $("<div>").addClass("servingsContainer");
                const serveringsHeader = $("<h2>").text("Servings");
                const halfButton = createServingsButton("Half", 0.5, ingredients);
                const singleButton = createServingsButton("Single", 1, ingredients);
                const doubleButton = createServingsButton("Double", 2, ingredients);

                servingsDiv.append(
                    serveringsHeader,
                    halfButton,
                    singleButton,
                    doubleButton
                );

                return servingsDiv;
            }

            function createServingsButton(label, multiplier, ingredients) {
                return $("<button>")
                    .text(label)
                    .on("click", function () {
                        adjustServings(ingredients, multiplier);
                    });
            }

            function adjustServings(ingredients, multiplier) {
                const adjustedIngredients = ingredients
                    .split(",")
                    .map(ingredient => adjustQuantity(ingredient.trim(), multiplier));
                $(".recipeIngredients").empty();
                adjustedIngredients.forEach(ingredient => {
                    $(".recipeIngredients").append($("<li>").text(ingredient));
                });
            }

            function createIngredientsSection(ingredients) {
                const ingredientsDiv = $("<div>").addClass("recipeContainerIngredients");
                const ingredientsHeader = $("<h2>").text("Ingredients");
                const toggleButton = $("<button>")
                    .text("Show Ingredients")
                    .on("click", function () {
                        toggleSection(".recipeIngredients", this);
                    });

                const ingredientsList = $("<ul>").addClass("recipeIngredients").hide();
                const ingredientItems = ingredients.split(",");

                ingredientItems.forEach(item => {
                    ingredientsList.append($("<li>").text(item.trim()));
                });

                ingredientsDiv.append(ingredientsHeader, toggleButton, ingredientsList);
                return ingredientsDiv;
            }

            function createDirectionsSection(instructions) {
                const directionsDiv = $("<div>").addClass("recipeContainerDirections");
                const directionsHeader = $("<h2>").text("Directions");
                const toggleButton = $("<button>")
                    .text("Show Directions")
                    .on("click", function () {
                        toggleSection(".recipeDirections", this);
                    });

                const directionsList = $("<ul>").addClass("recipeDirections").hide();
                const directionItems = instructions.split(",");

                directionItems.forEach(item => {
                    directionsList.append($("<li>").text(item.trim()));
                });

                directionsDiv.append(directionsHeader, toggleButton, directionsList);
                return directionsDiv;
            }

            function toggleSection(sectionClass, button) {
                const section = $(sectionClass);
                section.toggle();
                const isVisible = section.is(":visible");
                $(button).text(isVisible ? `Hide ${sectionClass.includes("Ingredients") ? "Ingredients" : "Directions"}` : `Show ${sectionClass.includes("Ingredients") ? "Ingredients" : "Directions"}`);
            }

            function adjustQuantity(ingredient, multiplier) {
                // Helper functions for parsing and formatting fractions
                function parseFraction(fraction) {
                    if (fraction.includes('/')) {
                        const parts = fraction.split('/');
                        return parseInt(parts[0]) / parseInt(parts[1]);
                    }
                    return parseFloat(fraction);
                }

                function toFraction(decimal) {
                    const tolerance = 1.0e-6; 
                    let numerator = 1, denominator = 1;

                    while (Math.abs(numerator / denominator - decimal) > tolerance) {
                        if (numerator / denominator < decimal) {
                            numerator++;
                        } else {
                            denominator++;
                        }
                    }
                    return `${numerator}/${denominator}`;
                }

                const match = ingredient.match(/^(\d+\/\d+|\d+)(.*)/);
                if (!match) return ingredient;

                const quantity = match[1];
                const description = match[2];
                const numericQuantity = parseFraction(quantity);
                const adjustedQuantity = numericQuantity * multiplier;

                return `${toFraction(adjustedQuantity)} ${description.trim()}`;
            }
        });
    </script>
</head>

<body>
    <nav>
        <ul>
            <li><a href="ajaxHome page.php">Home</a></li>
            <li><a href="allRecipePage.php">All Recipes</a></li>
            <li><a href="contactPage.php">Contact</a></li>
            <li><a href="../admin/login.php">Login</a></li>
        </ul>
    </nav>
    <main></main>
    <footer>
            <?php 
            echo "recipe manager". date("Y") . "©";
            ?>
        </footer>
</body>

</html>
