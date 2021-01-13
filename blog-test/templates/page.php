<div class="article">
    <h1 class="article__title"><?= $data['article']['title'] ?></h1>
    <p class="article__tags"> <?= $data['article']['tags'] ?></p>
    <p class="article__content"><?= $data['article']['content'] ?></p>
</div>
<hr>
<div class="comments">
    
    <form action="/comment/<?= $data['article']['id'] ?>" method="post" enctype="multipart/form-data">
        <p>new comment</p>
        <div class="form__item">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" placeholder="test@example.com">
        </div>
        <div class="form__item">
            <label for="content">Content</label>
            <textarea name="content" id="content" minlength="20" cols="30" rows="3"></textarea>
        </div>
        <div class="form__item">
            <label for="image">Load image</label>
            <input type="file" id="image" name="image" onchange="loadFile(event)">
        </div>
        <div class="form__item submit">
            <input type="submit" name="submit" value="Save">
        </div>
    </form>
    <div class="image-wrapper">
        <img id="output" alt="" src="">
    </div>
    <p>Other comments...</p>
    
    <?php foreach ($data['comments'] as $comment) { ?>
    <div class="comment">
        <div class="comment__author"><?=$comment['email']?></div>
        <div class="comment__text"><?=$comment['content']?></div>
		<?php foreach ($comment['images'] as $image) { ?>
        <div class="image-wrapper">
		    <img src="<?=$image['src']?>" alt="<?=$image['name']?>">
        </div>
		<?php } ?>
    </div>
    <?php } ?>
</div>
<script src="/js/preview.js"></script>
