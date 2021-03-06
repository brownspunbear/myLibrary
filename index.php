<?php
session_start();
require_once 'functions/functions.php';
filterIt();
sortIt();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Library</title>
    <link rel="stylesheet" type="text/css" href="normalize.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<header>
    My Library
</header>

<main>

    <label for="toggler" class="sidePaneToggle">+ Add a book</label>
    <input type="checkbox" id="toggler" name="toggler" />

    <section class="sidePane">

        <form method="post" class="addEdit addIt">
            <?php require 'add.php'; ?>
        </form>

    </section>

    <section class="displayPane">

        <div class="filterSearch">

            <form method="get" class="filter">
                <div>
                    <img src="img/filter.png" alt="filter" />
                    <select id="filterBy" name="filterBy">
                        <option value="">Any</option>
                        <option value="5">5 star</option>
                        <option value="4">4 star</option>
                        <option value="3">3 star</option>
                        <option value="2">2 star</option>
                        <option value="1">1 star</option>
                    </select>
                    <input type="submit" value="Filter!" class="smallSubmit" />
                </div>
            </form>

            <form method="get" class="search">
                <div>
                    <img src="img/search.png" alt="search" />
                    <input type="search" id="searchBy" name="searchBy" />
                    <input type="submit" value="Search!" />
                </div>
            </form>

        </div>

        <div class="displayTable">

            <table>
                <tr>
                    <form method="get">
                        <th class="vitalCell longCell">
                            <input type="submit" name="sortBy" value="Title" class="tableSubmit" />
                        </th>
                        <th class="vitalCell longCell">
                            <input type="submit" name="sortBy" value="Author" class="tableSubmit" />
                        </th>
                        <th class="usefulCell shortCell">
                            <input type="submit" name="sortBy" value="Year" class="tableSubmit" />
                        </th>
                        <th class="usefulCell medCell">
                            <input type="submit" name="sortBy" value="Category" class="tableSubmit" />
                        </th>
                        <th class="maybeCell shortCell centerCell">
                            <input type="submit" name="sortBy" value="Rating" class="tableSubmit centerCell" />
                        </th>
                    </form>
                    <th class="vitalCell shortCell centerCell">
                        Edit
                    </th>
                    <th class="maybeCell vShortCell centerCell">
                        Del
                    </th>
                </tr>
                <?php displayLibrary($db); ?>
            </table>

        </div>

    </section>

</main>

</body>
</html>