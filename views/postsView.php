<?php include __DIR__ . '/layout/header.php'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <form class="d-flex" method="get" action="">
                <input class="form-control me-2" type="search" name="q" placeholder="Пошук за заголовком" value="<?= htmlspecialchars(isset($searchQuery) ? $searchQuery : '', ENT_QUOTES, 'UTF-8') ?>">
                <button class="btn btn-primary" type="submit">Пошук</button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php if (!empty($posts)): ?>
            <?php
                $parsedown = new Parsedown();
                $parsedown->setSafeMode(true);
            ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($post->title, ENT_QUOTES, 'UTF-8') ?></h5>
                            <div class="card-text">
                                <?php
                                $content = isset($post->content) ? (string)$post->content : '';
                                if ($parsedown) {
                                    echo $parsedown->text($content);
                                } else {
                                    echo nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8'));
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            Опубліковано: <?= htmlspecialchars($post->createdAt, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">Нічого не знайдено за запитом «<?= htmlspecialchars(isset($searchQuery) ? $searchQuery : '', ENT_QUOTES, 'UTF-8') ?>».</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
