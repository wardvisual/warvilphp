<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form id="myForm">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required />

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required />

        <button type="button" onclick="submitForm()">Submit</button>
    </form>

    <script>
        var submitForm = async () => {
            var formData = new FormData();

            // Get values from input fields
            var nameValue = document.getElementById("name").value;
            var ageValue = document.getElementById("age").value;

            // Append form data
            formData.append('name', nameValue);
            formData.append('age', ageValue);


            var response = await fetch("/mvc/home/store", {
                method: "POST",
                body: formData,
            });

            var result = await response.json();

            console.log(result);
        }
    </script>

</body>

</html>