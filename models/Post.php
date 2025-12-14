<?php

require_once __DIR__ . '/../config/db.php';

class Post
{
    public $id;
    public $title;
    public $content;
    public $created_at;

    public function __construct($id, $title, $content, $created_at)
    {
        $this->id = (int)$id;
        $this->title = (string)$title;
        $this->content = (string)$content;
        $this->created_at = (string)$created_at;
    }

    public static function getAll()
    {
        $conn = getDbConnection();
        $sql = "SELECT id, title, content, created_at FROM posts ORDER BY created_at DESC";
        $result = $conn->query($sql);

        $posts = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = new Post($row['id'], $row['title'], $row['content'], $row['created_at']);
            }
            $result->free();
        }
        return $posts;
    }

    public static function search($query)
    {
        $query = (string)$query;
        $conn = getDbConnection();
        $sql = "SELECT id, title, content, created_at FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Помилка підготовки запиту: ' . $conn->error);
        }
        $like = '%' . $query . '%';
        $stmt->bind_param('ss', $like, $like);
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = new Post($row['id'], $row['title'], $row['content'], $row['created_at']);
            }
        }
        $stmt->close();
        return $posts;
    }
}
