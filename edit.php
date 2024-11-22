<?php
include 'Controller.php';
$controller = new Controller();
$post=[];
session_start();
//edit
if (isset($_GET['edit'])) {
    if($_GET['edit']==1){
        if (isset($_GET['id'])) {
            $postId = $_GET['id'];
            $post = $controller->getPost($postId);
            // var_dump($post);
            // $controller->edit($postId);
        }
    }
}
if (isset($_POST['submit'])) {
    $id=$_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    $target_dir = 'uploads/';
    $image = $target_dir . basename($_FILES['image']['name']);  
    $controller->edit($id,$title, $author, $content, $image);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="#">
                <h3>Edit Blog</h3>
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
                <h3>Edit existing Blog Post</h3>
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
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        <input type="hidden" name="id" id="id" class="form-control" value=<?php echo $post['id']?>>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" name="author" id="author" class="form-control" value="<?php echo htmlspecialchars($post['author']);?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea name="content" id="content" rows="4" class="form-control" required><?php echo htmlspecialchars($post['content']);?></textarea>
                    </div>

                    <div class="mb-3">
                        <img src="<?php echo $post['image']?>" alt="" style="width:20%;"><br>
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" name="image" id="image" class="form-control"  required>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-danger">Submit Blog Post</button>
                    </div>
                </form>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
