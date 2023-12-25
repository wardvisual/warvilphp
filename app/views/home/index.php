<div>
    <h1>Home</h1>
    <button onclick="add()">add user</button>
    <hr />
    <div id="data">
        <?php Card($data['users'], 'upper'); ?>
    </div>
</div>

<script>
const upper = id => {
    // delete user
    fetch('home/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id
        })
    }).then(() => {

    })
}

const add = () => {
    // add data to card
    fetch('home/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: 'test',
            email: 'test@gmai.com'
        })
    })
}
</script>