<div class="container">
    <h1><?= $title ?? 'Home List' ?></h1>
    
    <div class="actions">
        <a href="/home/create" class="btn">Create New Home</a>
    </div>
    
    <div class="items-list">
        <?php if(empty($items)): ?>
            <p>No homes found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['name'] ?? 'Unnamed' ?></td>
                            <td>
                                <a href="/home/show?id=<?= $item['id'] ?>">View</a>
                                <a href="/home/edit?id=<?= $item['id'] ?>">Edit</a>
                                <form action="/home/destroy" method="post" style="display: inline">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>