<?php

class Post
{
    public $title;
    public $content;
    public $createdAt;

    public function __construct($title, $content, $createdAt)
    {
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    public static function getAll()
    {
        return [
            new Post(
                'Мій перший пост',
                "Це приклад першого поста в блозі.\n\n- Пункт списку 1\n- Пункт списку 2\n\nТрохи **жирного** та _курсиву_.",
                self::dateMinusDays(4)
            ),
            new Post(
                'MVC у PHP',
                "MVC — це розділення коду на три частини: **Model**, **View**, **Controller**.",
                self::dateMinusDays(3)
            ),
            new Post(
                'Composer',
                "Composer — менеджер залежностей для PHP. Встановлення: `composer install`.",
                self::dateMinusDays(2)
            ),
            new Post(
                'GitHub',
                "GitHub — сервіс для зберігання та спільної роботи над кодом. Перейдіть у репозиторій і зробіть `git push`.",
                self::dateMinusDays(1)
            ),
            new Post(
                'Наступний крок',
                "Далі можна додати пошук, Markdown або базу даних.\n\nПриклад коду:\n\n```php\necho 'Hello, MVC!';\n```",
                self::dateMinusDays(0)
            ),
        ];
    }

    /**
     * @param string $query
     * @return Post[]
     */
    public static function searchByTitle($query)
    {
        $query = trim((string)$query);
        if (function_exists('mb_strtolower')) {
            $query = mb_strtolower($query, 'UTF-8');
        } else {
            $query = strtolower($query);
        }
        if ($query === '') {
            return self::getAll();
        }
        $result = [];
        foreach (self::getAll() as $post) {
            $title = mb_strtolower($post->title, 'UTF-8');
            $found = (mb_strpos($title, $query, 0, 'UTF-8') !== false);

            if ($found) {
                $result[] = $post;
            }
        }
        return $result;
    }

    private static function dateMinusDays($days)
    {
        $now = \Carbon\Carbon::now();
        return $now->copy()->subDays((int)$days)->format('d.m.Y');
    }
}
