<div>

    <form>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required /> <br />

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required />

        <button>Submit</button>
    </form>

    <?php dd($data['users']); ?>
    <script src="public/js/apiFormHandler.js"></script>

    <script>
    apiFormRequest({
        method: 'POST',
        url: 'home/store',
        actions: {
            onSuccess: (response) => {
                // location.reload();
                console.log(response);
            },
            onError: (error) => {
                console.log(error);
            }
        }
    })
    </script>

</div>