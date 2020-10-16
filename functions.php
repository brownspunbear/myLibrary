<?php

$db = new PDO('mysql:host=db; dbname=myLibrary', 'root', 'password');

/**
 * Get the current GET request (filter/search) and add to SESSION
 * or if no GET filter/search and SESSION already has a filterBy, do nothing
 * or if no GET filter/search and no SESSION filter/search, set SESSION filter/search to ''
 */
function filterIt() {
    if (isset($_GET['filterBy'])) {
        $_SESSION['filterBy'] = $_GET['filterBy'];
    } elseif (isset($_GET['searchBy'])) {
        $_SESSION['filterBy'] = $_GET['searchBy'];
    } elseif (isset($_SESSION['filterBy'])) {
        return;
    } else {
        $_SESSION['filterBy'] = '';
    }
}

/**
 * Get the current sortBy GET request and add to SESSION
 * or if no GET sortBy, set SESSION sortBy to 'author'
 */
function sortIt() {
    if (isset($_GET['sortBy'])) {
        switch ($_GET['sortBy']) {
            case 'Title':
                $_SESSION['sortBy'] = 'title, author';
                break;
            case 'Author':
                $_SESSION['sortBy'] = 'author, title';
                break;
            case 'Year':
                $_SESSION['sortBy'] = 'year, author';
                break;
            case 'Category':
                $_SESSION['sortBy'] = 'category, author';
                break;
            case 'Rating':
                $_SESSION['sortBy'] = 'rating DESC';
                break;
            default:
                break;
        }
    } else {
        $_SESSION['sortBy'] = 'author';
    }
}

/**
 * Create connection to db, query db, echo table of items
 *
 * @param   object $db
 */
function displayLibrary(object $db) {
    try {
        $filter = $_SESSION['filterBy'];
        $sort = $_SESSION['sortBy'];
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $displayQuery = $db->prepare("SELECT * FROM books
                                        WHERE rating = :filter 
                                        OR title LIKE CONCAT('%', :filter, '%')
                                        OR author LIKE CONCAT('%', :filter, '%')
                                        ORDER BY $sort;");
        $displayQuery->bindParam(':filter', $filter);
        $displayQuery->execute();
        $myLibrary = $displayQuery->fetchAll();
        foreach ($myLibrary as $book) {
            echo '<tr><td class="vitalCell">'
                . $book['title']
                . '</td><td class="vitalCell">'
                . $book['author']
                . '</td><td class="usefulCell">'
                . $book['year']
                . '</td><td class="usefulCell medCell">'
                . $book['category']
                . '</td><td class="maybeCell centerCell">'
                . $book['rating']
                . '</td><td class="centerCell">
                  <form method="get" action="edit.php">
                  <button type="submit" name="edit" value="'
                . $book['title']
                . '">edit</button>
                  </form>
                  </td></td><td class="maybeCell centerCell">
                  <form method="post">
                  <button type="submit" name="delBook" value="'
                . $book['title']
                . '">x</button>
                  </form>
                  </td></tr>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

/**
 * Add a book
 */
if (isset($_POST['addBook'])) {
    $_SESSION['lastActive'] = time();
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $category = $_POST['category'];
    $rating = $_POST['rating'];
    try {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $db->prepare("INSERT INTO books (title, author, year, category, rating)
                            VALUE (:title, :author, :year, :category, :rating);");
        $query->bindParam(':title', $title);
        $query->bindParam(':author', $author);
        $query->bindParam(':year', $year);
        $query->bindParam(':category', $category);
        $query->bindParam(':rating', $rating);
        $query->execute();
        $_SESSION['update'] = "$title added successfully!";
    } catch (PDOException $e) {
        $_SESSION['update'] = 'Error: ' . $e->getMessage();
    }
    header('Location: index.php');
}

/**
 * Give success or error message upon add/edit/delete, and remove message from SESSION after one minute
 */
function notifyEdit() {
    if (isset($_SESSION['update'])) {
        echo $_SESSION['update'];
        if (isset($_SESSION['lastActive']) && (time() - $_SESSION['lastActive'] > 10)) {
            unset($_SESSION['update']);
        }
    }
}

/**
 * Delete book: send to confirmation page
 */
if (isset($_POST['delBook'])) {
    $_SESSION['delBook'] = $_POST['delBook'];
    header('Location: delete.php');
}

/**
 * Confirm delete
 */
if (isset($_POST['confirmDelete'])) {
    $_SESSION['lastActive'] = time();
    $title = $_SESSION['delBook'];
    try {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $db->prepare("DELETE FROM books WHERE title = :title;");
        $query->bindParam(':title', $title);
        $query->execute();
        $_SESSION['update'] = "$title deleted successfully!";
    } catch (PDOException $e) {
        $_SESSION['update'] = 'Error: ' . $e->getMessage();
    }
    header('Location: index.php');
} elseif (isset($_POST['cancelDelete'])) {
    header('Location: index.php');
}