<div class="container">
    <h1><?= $title ?? 'Edit Home' ?></h1>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <div class="actions">
        <a href="/home" class="btn">Back to List</a>
        <a href="/home/show?id=<?= $item['id'] ?>" class="btn">Details</a>
    </div>
    
    <form action="/home/update" method="post">
        <input type="hidden" name="id" value="<?= $item['id'] ?>">
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= $data['name'] ?? $item['name'] ?? '' ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?= $data['description'] ?? $item['description'] ?? '' ?></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Save</button>
        </div>
    </form>
</div>