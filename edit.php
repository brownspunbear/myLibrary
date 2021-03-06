<?php
session_start();
require_once 'functions/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Library | Update a book</title>
    <link rel="stylesheet" type="text/css" href="normalize.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<header>
    My Library
</header>

<section class="editIt">

    <form method="post" class="addEdit">
        <div>
            <h3>Update a book</h3>
            <input type="hidden" id="bookId" name="bookId" value="<?php echo $toEdit[0]['id']; ?>" />
            <div>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo $toEdit[0]['title']; ?>" required="required" />
            </div>
            <div>
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" value="<?php echo $toEdit[0]['author']; ?>" required="required" />
            </div>
            <div>
                <label for="year">Year:</label>
                <input type="number" id="year" name="year" max="2020" value="<?php echo $toEdit[0]['year']; ?>" required="required" />
            </div>
            <div>
                <label for="rating">My rating:</label>
                <input type="number" id="rating" name="rating" min="1" max="5" value="<?php echo $toEdit[0]['rating']; ?>" required="required" />
            </div>
            <div>
                <label for="category">Category:</label>
                <select id="category" name="category" required="required">
                    <option value="Fiction">Fiction</option>
                    <option value="Non-fiction">Non-fiction</option>
                </select>
            </div>
            <div>
                <input type="submit" name="editBook" value="Update!" class="addSubmit" />
            </div>
            <div>
                <input type="submit" name="editCancel" value="Cancel" class="addSubmit" />
            </div>
        </div>
    </form>

</section>

</body>
</html>