<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ward</title>
</head>

<body>
    <form id="registrationForm">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required />

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required />

        <button type="submit" onclick="submitForm()">Submit</button>
    </form>

    <script src="public/js/apiFormHandler.js"></script>

    <script>
        const props = {
            endpoint: 'home/store',
            formId: 'registrationForm'
        }

        const apiFormHandler = new ApiFormHandler(props);

        ApiForm({
            endpoint: 'home/store',
            formId: 'registrationForm',
            onSuccess: (response) => {
                console.log(response);
            },
            onError: (error) => {
                console.log(error);
            }
        })

        const submitForm = async () => {
            await apiFormHandler.submitForm();
        }
    </script>

</body>

</html>