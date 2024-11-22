<?php
class Controller
{
    public $jsonFile = 'blogs.json';
    public function createPost($title, $author, $content, $target_file)
    {
        $id = 0;

        if (file_exists($this->jsonFile)) {
            if (filesize($this->jsonFile) == 0) {
                $id = 1;
            } else {
                $jsonData = json_decode(file_get_contents($this->jsonFile), true);
                $lastElement = end($jsonData);
                $id = $lastElement['id'] + 1;
            }
        } else {
            $jsonData = [];
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $blogPost = [
                'id' => $id,
                'title' => $title,
                'author' => $author,
                'content' => $content,
                'image' => $target_file,
                'date' => date('d-m-Y'),
            ];

            $jsonData[] = $blogPost;

            if (file_put_contents($this->jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT))) {
                echo '<p>Blog post has been successfully saved!</p>';
                $_SESSION['message'] = 'Berhasil membuat postingan berjudul ' . $title;
                header('Location: /tugas-akhir/dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan saat akan menyimpan postingan!';
            }
        } else {
            $_SESSION['error'] = 'Terjadi kesalahan saat akan mengupload gambar!';
        }
    }
    public function delete($id)
    {
        if (file_exists($this->jsonFile)) {
            $jsonData = json_decode(file_get_contents($this->jsonFile), true);
            $title = '';
            $postIndex = -1; //penanda
            foreach ($jsonData as $index => $post) {
                if ($post['id'] == $id) {
                    $postIndex = $index;
                    $title = $post['title'];
                    break;
                }
            }

            // Jika post ditemukan, ngapus post
            if ($postIndex != -1) {
                // Hapus post
                $_SESSION['message'] = 'Berhasil menghapus postingan berjudul "' . $title . '"';
                unset($jsonData[$postIndex]);
                // Reindex array
                $jsonData = array_values($jsonData);
                file_put_contents($this->jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));
                header('Location: /tugas-akhir/dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Post tidak ditemukan!';
            }
        } else {
            $_SESSION['error'] = 'File blog tidak ditemukan!';
        }
    }
    public function edit($id, $title, $author, $content, $image)
    {
        if (file_exists($this->jsonFile)) {
            $jsonData = json_decode(file_get_contents($this->jsonFile), true);

            // Flag to track if the post was found and updated
            $isUpdated = false;

            // Iterate through the posts by reference
            foreach ($jsonData as &$post) {
                if ($post['id'] == $id) {
                    // Update the post fields
                    $post['title'] = $title;
                    $post['author'] = $author;
                    $post['content'] = $content;
                    $post['image'] = $image;
                    move_uploaded_file($_FILES['image']['tmp_name'], $image);
                    $isUpdated = true; // Mark as updated
                    break; // Stop looping once the post is found and updated
                }
            }

            if ($isUpdated) {
                // Write updated data back to the file
                if (file_put_contents($this->jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT))) {
                    $_SESSION['message'] = 'Post updated successfully!';
                    header('Location: /tugas-akhir/dashboard.php');
                    exit();
                } else {
                    $_SESSION['error'] = 'Failed to save updated post!';
                }
            } else {
                $_SESSION['error'] = 'Post not found!';
            }
        } else {
            $_SESSION['error'] = 'Blog file not found!';
        }
    }

    public function getPost($id)
    {
        if (file_exists($this->jsonFile)) {
            $jsonData = json_decode(file_get_contents($this->jsonFile), true);

            foreach ($jsonData as $post) {
                if ($post['id'] == $id) {
                    $blog = [
                        'id' => $post['id'],
                        'title' => $post['title'],
                        'author' => $post['author'],
                        'content' => $post['content'],
                        'image' => $post['image'],
                    ];
                    return $blog;
                }
            }

        } else {
            $_SESSION['error'] = 'File blog tidak ditemukan!';
        }
    }
}
?>
