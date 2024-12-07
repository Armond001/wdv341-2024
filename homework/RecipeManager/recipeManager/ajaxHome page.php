<?php 
session_start();

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


    
    <style>
      
    </style>
    <script>
      $(document).ready(function () {
    // Fetch data
    $.ajax({
        url: "ajax.php",
        method: "GET",
        dataType: "json",
        success: function (data) {
            const { recipeAsideData, recipeFeatureData1, recipeFeatureData2 } = data;

            let featureRecipe1 = createFeatureCard(recipeFeatureData1[0]);
            let featureRecipe2 = createFeatureCard(recipeFeatureData2[0]);

            let asideRecipe1 = createAsideCard(recipeAsideData[0]);
            let asideRecipe2 = createAsideCard(recipeAsideData[1]);
            let asideRecipe3 = createAsideCard(recipeAsideData[2]);

            let recipeAsideDiv = document.querySelector("#RecipeListAside");
            let recipeRowDiv = document.querySelector("#recipeRowContainer");

            recipeRowDiv.append(featureRecipe1, featureRecipe2);
            recipeAsideDiv.append(asideRecipe1, asideRecipe2, asideRecipe3);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching recipes:", error);
        },
    });
});
// create aside recipe cards
function createAsideCard(incard) {
    let asideDiv = document.createElement("div");
    asideDiv.setAttribute("class", "recipeCardAside");

    let asideh3 = document.createElement("h3");
    let recipelink = document.createElement("a");
    recipelink.setAttribute("href", "recipePage.php?recipeID=" + incard.id);
    recipelink.innerHTML = incard.recipeName;
    asideh3.append(recipelink);
    asideDiv.appendChild(asideh3);

    let asideP = document.createElement("P");
    asideP.innerText = incard.recipeDescription;

    let newImg = document.createElement("img");
    newImg.setAttribute("class", "recipeCardAsideImage");
    newImg.setAttribute("src", "../Images/" + incard.image);

    asideDiv.appendChild(newImg);
    asideDiv.appendChild(asideh3);
    asideDiv.appendChild(asideP);

    return asideDiv;
}
// create featured recipes
function createFeatureCard(incard) {
    let featureDiv = document.createElement("div");
    featureDiv.setAttribute("class", "recipeCard");

    let featureh3 = document.createElement("h3");
    let recipelink = document.createElement("a");
    recipelink.setAttribute("href", "recipePage.php?recipeID=" + incard.id);
    recipelink.innerHTML = incard.recipeName;
    featureh3.append(recipelink);
    featureDiv.appendChild(featureh3);

    let featureP = document.createElement("P");
    featureP.innerText = incard.recipeDescription;

    let newImg = document.createElement("img");
    newImg.setAttribute("class", "recipeCardImage");
    newImg.setAttribute("src", "../Images/" + incard.image);

    featureDiv.appendChild(newImg);
    featureDiv.appendChild(featureh3);
    featureDiv.appendChild(featureP);

    return featureDiv;
}
    

     
      
    </script>
</head>

<body>
    <div class="gridContainer">
        
        <nav>
            <ul>
                <li><a href="ajaxHome page.php">Home</a></li>
                <li><a href="allRecipePage.php">all recipes</a></li>
                <li><a href="contactPage.php">Contact</a></li>  
                <li><a href="../admin/login.php">login</a></li>
            </ul>
        </nav>


        <div id="recipeRowContainer">
            <!--load preselected recipe from database  

            -->
           

        </div>

        <main>
            <div id="RecipeListAside">
            
            </div>

        
        </main>
        <footer>
            <?php 
            echo "recipe manager". date("Y") . "©";
            ?>
        </footer>
    </div>
   
</body>

</html>