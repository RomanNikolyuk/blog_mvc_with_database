<?php
require_once __DIR__ . '/../models/Post.php';

class BlogController
{
    public function showAllPosts($query = '')
    {
        $query = trim($query);
        if ($query !== '') {
            $posts = Post::searchByTitle($query);
        } else {
            $posts = Post::getAll();
        }

        $pageTitle = 'Мій блог';
        $searchQuery = $query;

        include __DIR__ . '/../views/postsView.php';
    }
}
