<!DOCTYPE html>
<html>
    <head>
        <title>Opinion Page</title>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    </head>
<body>
    <h1>My opinion of SENG365 so far</h1>
    <p>
        <?php
            $buttons = array('Excellent', 'Good', 'OK', 'Substandard', 'Dreadful', 'What\'s SENG365?');
            $name = $_POST['username'];
            $opinion = $buttons[$_POST['opinion']];
            $check = preg_match('|^[a-z]{3}[0-9]{2,3}$|', $name);
            if ($check and isset($_POST['opinion'])) {
                echo "Thanks, $name, for your opinion of SENG365 (namely \"$opinion\")."; echo '<br>';
            }
            else {
                echo "Bad input data"; echo '<br>';
            }
        ?>
    </p>
</body>
</html>

