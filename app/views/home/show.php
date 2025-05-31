<div class="container">
    <h1><?= $title ?? 'Home Details' ?></h1>
    
    <div class="actions">
        <a href="/home" class="btn">Back to List</a>
        <a href="/home/edit?id=<?= $item['id'] ?>" class="btn">Edit</a>
        <form action="/home/destroy" method="post" style="display: inline">
            <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <button type="submit" class="btn" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
    
    <div class="details">
        <p><strong>ID:</strong> <?= $item['id'] ?></p>
        <p><strong>Name:</strong> <?= $item['name'] ?? 'Unnamed' ?></p>
        <p><strong>Description:</strong> <?= $item['description'] ?? 'No description' ?></p>
        <p><strong>Created:</strong> <?= $item['created_at'] ?? 'Unknown' ?></p>
    </div>
</div>