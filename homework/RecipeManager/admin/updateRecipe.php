<?php 
session_start();
if (!isset($_SESSION['validUser'])) {
    header('Location: login.php'); // Redirect to login page for unauthorized access
    exit;
}

require "../dbConnect/dbConnect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Initialize variables and errors
$formRequested = true;
$validForm = true;
$nameError = $descriptionError = $cookingTimeError = $difficultyError = $directionError = $ingredientError = $imgError = "";
$confirmationMessage = "";

// Fetch recipe data if `recipeID` is provided
if (isset($_GET['recipeID']) && is_numeric($_GET['recipeID'])) {
    $recipeID = $_GET['recipeID'];
    
    $sql = "SELECT * FROM recipes WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $recipeID, PDO::PARAM_INT);
    $stmt->execute();
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recipe) {
        echo "Recipe not found.";
        exit;
    }
} else {
    echo "Invalid ID.";
    exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Simple validation
    if (empty($_POST["recipeName"])) {
        $nameError = "Enter Recipe Name";
        $validForm = false;
    }

    if (empty($_POST["recipeDescription"])) {
        $descriptionError = "Enter Recipe Description";
        $validForm = false;
    }

    if (empty($_POST['recipeDifficulty'])) {
        $difficultyError = "Choose recipe difficulty";
        $validForm = false;
    }

    if (empty($_POST['recipeCookingTime'])) {
        $cookingTimeError = "Enter Recipe Cooking Time";
        $validForm = false;
    }

    if (empty($_POST['recipeIngredients'][0])) {
        $ingredientError = "Enter at least one ingredient";
        $validForm = false;
    }

    if (empty($_POST['recipeDirection'][0])) {
        $directionError = "Enter at least one direction";
        $validForm = false;
    }

    if ($validForm) {
        // Process the updated data
        $recipeName = $_POST["recipeName"];
        $recipeDescription = $_POST["recipeDescription"];
        $recipeDifficulty = $_POST['recipeDifficulty'];
        $recipeCookingTime = $_POST['recipeCookingTime'];
        $recipeDirection = implode(",", $_POST['recipeDirection']);
        $recipeIngredients = implode(",", $_POST['recipeIngredients']);

        $imageNewName = $recipe['image']; // Default to the existing image name

        // Handle image upload if a new file is provided
        if (!empty($_FILES['recipeIamge']['name'])) {
            $imageName = $_FILES['recipeIamge']["name"];
            $imageTmpName = $_FILES['recipeIamge']["tmp_name"];
            $imageSize = $_FILES['recipeIamge']["size"];
            $imageError = $_FILES['recipeIamge']["error"];
            $imageType = $_FILES['recipeIamge']["type"];

            $imageExt = explode(".", $imageName);
            $imageActualExt = strtolower(end($imageExt));

            $allowedImage = ["jpg", "jpeg", "png"];
            if (in_array($imageActualExt, $allowedImage)) {
                if ($imageError === 0) {
                    if ($imageSize < 500000) {
                        $imageNewName = uniqid("", true) . "." . $imageActualExt; 
                        $imageDestination = "../images/" . $imageNewName;
                        move_uploaded_file($imageTmpName, $imageDestination);
                    } else {
                        $imgError = "File is too big";
                        $validForm = false;
                    }
                } else {
                    $imgError = "Error with file upload";
                    $validForm = false;
                }
            } else {
                $imgError = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
                $validForm = false;
            }
        }

        // Update the database if the form is valid
        if ($validForm) {
            $data = [
                'recipeName' => $recipeName,
                'description' => $recipeDescription,
                'difficulty' => $recipeDifficulty,
                'cookingTime' => $recipeCookingTime,
                'instructions' => $recipeDirection,
                'ingredients' => $recipeIngredients,
                'image' => $imageNewName,
                'id' => $recipeID
            ];

            $sql = "UPDATE recipes 
                    SET recipeName = :recipeName, description = :description, difficulty = :difficulty, 
                        cookingTime = :cookingTime, instructions = :instructions, ingredients = :ingredients, 
                        image = :image 
                    WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);

            // Confirmation message
            $confirmationMessage = "Recipe updated successfully!";
            $formRequested = false; // Do not show the form after submission
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP homework</title>
    <meta name="keywords" content=" jacob, web development homework">
    <meta name="Author:" value="Jacob Scroggins">
    <meta name="destription" content="homework ">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../StyleSheets/recipeMangerStyleSheet.css">

    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-size: cover;  /* Makes the background image cover the entire page */
            height: 100%; /* Ensures the background spans the full page */
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Keeps content at the top */
            min-height: 100vh; 
            background-image:url("../Images/french-country-kitchen-style.jpg") ;
        }
        /* Form styling */
    #updateForm {
        background-color: rgba(255, 255, 255, 0.8); /* White background with transparency */
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
       
        width: 100%;
        margin: 0 20px;
    }

    /* Form labels */
    label {
        font-size: 1.2em;
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    /* Input fields */
    input[type="text"],
    input[type="file"],
    input[type="radio"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1em;
    }

    /* Submit and Reset Buttons */
    input[type="submit"],
    input[type="reset"] {
        width: 48%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #5cb85c; /* Green background */
        color: white;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover,
    input[type="reset"]:hover {
        background-color: #4cae4c;
    }

    .confirmationMessage {
        background-color: #d4edda; /* Light green background for success */
        color: #155724; /* Dark green text */
        border: 1px solid #c3e6cb; /* Slightly darker green border */
        padding: 15px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
        margin: 20px 0;
    }
    .returnLink {
        display: inline-block;
        margin-top: 10px;
        color: #155724;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #c3e6cb;
        padding: 10px 15px;
        border-radius: 5px;
        background-color: #f8f9fa; /* Light background for the link */
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .returnLink:hover {
        background-color: #d4edda; /* Match the confirmation box */
        color: #155724;
    }
</style>
</head>
<body>
<div class="inputForm" id="updateForm">
    <header>
        <h1>Update Recipe</h1>
    </header>
    <?php if ($formRequested) { ?>
        <form method="post" action="updateRecipe.php?recipeID=<?php echo $recipeID; ?>" enctype="multipart/form-data">
            <p>
                <label for="recipeName">Recipe Name</label>
                <input type="text" name="recipeName" id="recipeName" value="<?php echo htmlspecialchars($recipe['recipeName']); ?>">
                <span class="errMsg"><?php echo $nameError; ?></span>
            </p>

            <p>
                <label for="recipeDescription">Recipe Description</label>
                <input type="text" name="recipeDescription" id="recipeDescription" value="<?php echo htmlspecialchars($recipe['description']); ?>">
                <span class="errMsg"><?php echo $descriptionError; ?></span>
            </p>

            <p>
                <label for="recipeIamge">Recipe Image</label>
                <input type="file" name="recipeIamge" id="recipeImage" accept="image/png, image/jpeg">
                <span class="errMsg"><?php echo $imgError; ?></span>
            </p>

            <p>
                Recipe Difficulty
                <span class="errMsg"><?php echo $difficultyError; ?></span>
            </p>
            <p>
                <input type="radio" id="easy" name="recipeDifficulty" value="easy" <?php echo ($recipe['difficulty'] == 'easy') ? 'checked' : ''; ?>>
                <label for="easy">Easy</label><br>
                <input type="radio" id="intermediate" name="recipeDifficulty" value="intermediate" <?php echo ($recipe['difficulty'] == 'intermediate') ? 'checked' : ''; ?>>
                <label for="intermediate">Intermediate</label><br>
                <input type="radio" id="masterChef" name="recipeDifficulty" value="master chef" <?php echo ($recipe['difficulty'] == 'master chef') ? 'checked' : ''; ?>>
                <label for="masterChef">Master Chef</label>
            </p>

            <p>
                <label for="recipeCookingTime">Cooking Time</label>
                <input type="text" name="recipeCookingTime" id="recipeCookingTime" value="<?php echo htmlspecialchars($recipe['cookingTime']); ?>">
                <span class="errMsg"><?php echo $cookingTimeError; ?></span>
            </p>

            <p>
                <label for="recipeIngredients">Recipe Ingredients</label>
                <span class="errMsg"><?php echo $ingredientError; ?></span>
                <div id="ingredientContainer">
                    <?php 
                    $ingredients = explode(",", $recipe['ingredients']);
                    foreach ($ingredients as $index => $ingredient) {
                        echo "<input type='text' name='recipeIngredients[$index]' value='" . htmlspecialchars($ingredient) . "'><br>";
                    }
                    ?>
                </div>
            </p>

            <p>
                <label for="recipeDirection">Recipe Directions</label>
                <span class="errMsg"><?php echo $directionError; ?></span>
                <div id="directionContainer">
                    <?php 
                    $directions = explode(",", $recipe['instructions']);
                    foreach ($directions as $index => $direction) {
                        echo "<input type='text' name='recipeDirection[$index]' value='" . htmlspecialchars($direction) . "'><br>";
                    }
                    ?>
                </div>
            </p>

            <p>
                <input type="submit" value="Update Recipe" name="submit">
                <input type="reset" value="Reset">
            </p>
        </form>
    <?php } else { ?>
        <div class="confirmationMessage">
            Recipe updated successfully!
        </div>
    <a href="login.php" class="returnLink">Return to Login</a>
<?php } ?>
</div>
