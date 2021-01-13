<h1 class="title"> Create new Article</h1>

<form action="/admin/create" method="post">

    <div class="form__item">
        <label for="title">Title</label>
        <input type="text" name="title" id="title">
    </div>
    
    <div class="form__item">
        <label for="tags">Tags (separate ,)</label>
        <input type="text" name="tags" id="tags">
    </div>

    <div class="form__item">
        <label for="content">Content</label>
        <textarea name="content" id="content" rows="15"></textarea>
    </div>
    
    <div class="form__item">
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="new">New</option>
            <option value="open">Open</option>
            <option value="closed">Closed</option>
        </select>
    </div>
    
    <div class="form__item submit">
        <input type="submit" name="submit" value="Create">
    </div>
    
</form>