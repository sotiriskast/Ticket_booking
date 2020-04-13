<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Tournament: connection error</title>
  <link rel="stylesheet" href="/CSS/style.css">
</head>

<body>
    <p id="error">
        <!--insert error message here--><?php if (isset($_GET['error'])) echo $_GET['error']; ?></p>
</body>

</html>