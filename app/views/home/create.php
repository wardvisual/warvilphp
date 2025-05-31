<div class="container">
    <h1><?= $title ?? 'Create New Home' ?></h1>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <div class="actions">
        <a href="/home" class="btn">Back to List</a>
    </div>
    
    <form action="/home/store" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= $data['name'] ?? '' ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?= $data['description'] ?? '' ?></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Create</button>
        </div>
    </form>
</div>