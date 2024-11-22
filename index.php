<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <h3>BLOG</h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <h2 class="mb-4">Lihat postingan berikut: </h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $jsonFile = 'blogs.json';
            if (file_exists($jsonFile)) {
                $jsonData = json_decode(file_get_contents($jsonFile), true);
                if (!empty($jsonData)) {
                    foreach ($jsonData as $post) {
                        echo "<div class='col'>";
                        echo "    <div class='card h-100'>";
                        echo "        <img src='" . $post['image'] . "' class='card-img-top' alt='" . $post['title'] . "'>";
                        echo "        <div class='card-body'>";
                        echo "            <h5 class='card-title'><a href='post.php?id=" . $post['id'] . "'>" . $post['title'] . '</a></h5>';
                        echo "            <p class='card-text'>" . substr($post['content'], 0, 150) . '... </p>';
                        echo '        </div>';
                        echo "        <div class='card-footer'>";
                        echo "            <small class='text-muted'>By " . $post['author'] . ' on ' . $post['date'] . '</small>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    echo "<div class='alert alert-warning col-12'>No blog posts found.</div>";
                }
            } else {
                echo "<div class='alert alert-danger col-12'>Unable to read blog posts.</div>";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
