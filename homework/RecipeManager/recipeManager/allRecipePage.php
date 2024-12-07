<?php
if (isset($_SESSION['successMessage'])) {
    echo "<p style='color: green;'>" . $_SESSION['successMessage'] . "</p>";
    unset($_SESSION['successMessage']);
}
if (isset($_SESSION['errorMessage'])) {
    echo "<p style='color: red;'>" . $_SESSION['errorMessage'] . "</p>";
    unset($_SESSION['errorMessage']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recipe Project</title>
    <meta name="keywords" content=" jacob, web development homework">
    <meta name="Author:" value="Jacob Scroggins">
    <meta name="destription" content="homework ">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../StyleSheets/recipeMangerStyleSheet.css">

   

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    
    <style>
       

    </style>

    <script>
        $(document).ready(function () {
    // Fetch recipe data from the server
    $.ajax({
        url: "fetchAllRecipes.php", // The endpoint to fetch recipes
        method: "GET",
        dataType: "json",
        success: function (recipedata) {
            console.log("Recipes fetched:", recipedata); // Log the fetched data

            if (!recipedata || !Array.isArray(recipedata)) {
                console.error("Invalid recipe data:", recipedata);
                return;
            }

            let recipeCardDiv = document.querySelector("#recipeCardcontainer");

            recipedata.forEach(data => {
                let card = createAsideCard(data);
                recipeCardDiv.append(card);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching recipes:", error);
        }
    });
});

function createAsideCard(incard) {
    console.log("Creating card for:", incard); // Log each card creation

    let asideDiv = document.createElement("div");
    asideDiv.setAttribute("class", "recipeCard");

    // Name/Link
    let asideh3 = document.createElement("h3");
    let recipelink = document.createElement("a");
    recipelink.setAttribute("href", "recipePage.php?recipeID=" + incard.id);
    recipelink.innerHTML = incard.recipeName;
    asideh3.append(recipelink);
    asideDiv.appendChild(asideh3);

    // Description
    let asideP = document.createElement("P");
    asideP.innerText = incard.recipeDescription;

    // Image
    let newImg = document.createElement("img");
    newImg.setAttribute("class", "recipeCardImage");
    newImg.setAttribute("src", "../Images/" + incard.image);

    asideDiv.appendChild(newImg);
    asideDiv.appendChild(asideh3);
    asideDiv.appendChild(asideP);

    return asideDiv;
}


    </script>

</head>

<body>
    <header>
        
        
    </header>
    
    <nav>
        <ul>
            <li><a href="ajaxHome page.php">Home</a></li>
            <li><a href="allRecipePage.php">all recipes</a></li>
            <li><a href="../admin/login.php">login</a></li>
        </ul>
    </nav>

    <main>
        <div id="recipeCardcontainer">

        </div>
        
    </main>
</body>

</html>