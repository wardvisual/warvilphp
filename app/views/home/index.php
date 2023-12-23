<div>

    <form method='POST' enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="file" name="image" id="image" required /> <br />

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