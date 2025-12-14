<?php
require_once __DIR__ . '/../models/Post.php';

class BlogController
{
    public function showAllPosts($search = '')
    {
        $search = trim((string)$search);
        if ($search !== '') {
            $posts = Post::search($search);
        } else {
            $posts = Post::getAll();
        }

        $perPage = 3;
        $totalPages = max(1, (int)ceil(count($posts) / $perPage));
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) { $page = 1; }
        if ($page > $totalPages) { $page = $totalPages; }
        $offset = ($page - 1) * $perPage;
        $posts = array_slice($posts, $offset, $perPage);

        $pageTitle = 'Мій блог';

        include __DIR__ . '/../views/postsView.php';
    }
}
