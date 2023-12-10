<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ward</title>
</head>

<body>
    <form>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required />

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required />

        <button type="submit">Submit</button>
    </form>

    <script src="public/js/apiFormHandler.js"></script>

    <script>
        createFormApi({
            method: 'POST',
            url: 'home/store',
            actions: {
                onSuccess: (response) => {
                    alert(response);
                },
                onError: (error) => {
                    console.log(error);
                }
            }
        })
    </script>

</body>

</html>