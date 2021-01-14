<?php foreach ($data['articles'] as $datum) { ?>
    <div class="article">
        <a class="article__title" href="article/<?=$datum['id']?>"><?= htmlspecialchars($datum['title']) ?></a>
        <p class="article__tags"><?=$datum['tags']?></p>
        <div class="article__short-content"><?= htmlspecialchars(substr($datum['content'], 0, 200)) ?>...</div>
    </div>
    <hr>
<?php } ?>

