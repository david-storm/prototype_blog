<h1 class="title"><?=$data['operation']?> article</h1>

<form action="/<?=$data['action']?>" method="post">

    <div class="form__item">
        <label for="title">Title</label>
        <input type="text" required name="title" id="title" value="<?=$data['article']['title'] ?? ''?>">
    </div>
    
    <div class="form__item">
        <label for="tags">Tags (separate " ")</label>
        <input type="text" name="tags" id="tags" value="<?=$data['article']['tags'] ?? ''?>">
    </div>

    <div class="form__item">
        <label for="content">Content</label>
        <textarea name="content" required id="content" rows="15"><?=$data['article']['content'] ?? ''?></textarea>
    </div>
    
    <div class="form__item">
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="new" <?= ($data['article']['status'] ?? '') === 'new' ? 'selected' : '' ?>>New</option>
            <option value="open" <?= ($data['article']['status'] ?? '') === 'open' ? 'selected' : '' ?>>Open</option>
            <option value="closed" <?= ($data['article']['status'] ?? '') === 'closed' ? 'selected' : '' ?>>Closed</option>
        </select>
    </div>
    
    <div class="form__item submit">
        <input type="submit" name="submit" value="<?=$data['operation']?>">
    </div>
    
</form>