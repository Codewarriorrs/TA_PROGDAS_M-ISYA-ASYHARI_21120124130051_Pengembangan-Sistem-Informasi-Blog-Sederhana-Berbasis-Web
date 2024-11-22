<?php
include 'Controller.php';
$controller = new Controller();

session_start();
//create
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    $target_dir = 'uploads/';
    $target_file = $target_dir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $controller->createPost($title, $author, $content, $target_file);
}
//delete
if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    // Panggil method delete
    $controller->delete($postId);
}
//edit
if (isset($_GET['edit'])) {
    if (isset($_GET['id'])) {
        $postId = $_GET['id'];
        $controller->edit($postId);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="#">
                <h3>Dashboard Blog</h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/tugas-akhir/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3>Create a New Blog Post</h3>
            </div>
            <div class="card-body">
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['message'] . '</div>';
                    session_unset();
                    session_destroy();
                }
                if (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . '</div>';
                    session_unset();
                    session_destroy();
                }
                ?>


                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Blog Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" name="author" id="author" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea name="content" id="content" rows="4" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" name="image" id="image" class="form-control" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-danger">Submit Blog Post</button>
                    </div>
                </form>
            </div>
        </div>


        <h2 class="mt-5 text-center">Existing Blog Posts</h2>
        <div class="list-group">
            <?php
            if (file_exists('blogs.json')) {
                $jsonData = json_decode(file_get_contents('blogs.json'), true);
                if (!empty($jsonData)) {
                    foreach ($jsonData as $post) {
                        echo "<a href='post.php?id=" . $post['id'] . "' class='list-group-item list-group-item-action mb-2'>";
                        echo "  <h5 class='mb-1'>" . $post['title'] . '</h5>';
                        echo "  <p class='text-muted mb-1'>By " . $post['author'] . ' on ' . $post['date'] . '</p>';
                        echo "  <p class='mb-1'>" . substr($post['content'], 0, 150) . '...</p>';
                        echo "  <a href='?id=" . $post['id'] . "' class='btn btn-danger w-25 mb-3'>Delete</a>";
                        echo "<a href='edit.php?edit=1&id=" . $post['id'] . "' class='btn btn-warning btn-sm'>Edit</a>";
                        echo '</a>';
                    }
                } else {
                    echo "<div class='alert alert-warning'>No blog posts found.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Unable to read blog posts.</div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
