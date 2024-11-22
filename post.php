<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
       <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#"><h3>BLOG</h3></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/tugas-akhir/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            
            <div class="col-lg-10 col-md-10 col-sm-12">
                <?php
                $json_data = file_get_contents('blogs.json');
    
                $posts = json_decode($json_data, true);
                
                
                if (isset($_GET['id'])) {
                    $post_id = $_GET['id'];
                    $post_found = false;
                
                    foreach ($posts as $post) {
                        if ($post['id'] == $post_id) {
                            echo "<div class='card shadow-sm'>";
                            echo "    <img src='" . $post['image'] . "' class='card-img-top' alt='Post Image'>";
                            echo "    <div class='card-body'>";
                            echo "        <h1 class='card-title'>" . $post['title'] . '</h1>';
                            echo "        <p class='text-muted'><strong>Author:</strong> " . $post['author'] . ' | <strong>Date:</strong> ' . $post['date'] . '</p>';
                            echo '        <hr>';
                            echo "        <p class='card-text'>" . nl2br($post['content']) . '</p>';
                            echo '    </div>';
                            echo '</div>';
                            $post_found = true;
                            break;
                        }
                    }
                
                    if (!$post_found) {
                        echo "<div class='alert alert-warning text-center'>Post tidak ditemukan.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger text-center'>ID post belum diberikan.</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
