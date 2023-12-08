<div>
    <h1>Home Page</h1>
    <?php foreach($data['users'] as $user): ?>
        <ul>
            <li><?= $user['name'] ?></li>
            <li><?= $user['age'] ?></li>
        </ul>
    <?php endforeach; ?>
</form>
</div>