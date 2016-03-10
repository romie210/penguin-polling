<?php
$errors = array();
$username = "";
$selectedOpinion = NULL;
$buttons = array('Excellent', 'Good', 'OK', 'Substandard', 'Dreadful', 'What\'s SENG365?');
$isPostBack = isset($_POST['username']);

if ($isPostBack) {
    $username = $_POST['username'];
    if ($username == "") {
        array_push($errors, 'You must provide a username');
    }
    elseif (!preg_match('|^[a-z]{3}[0-9]{2,3}$|', $username)) {
        array_push($errors, 'Username must be 3 lower-case alphabetic characters followed be 2 or 3 digits ');
    }
    $opinion = $buttons[$_POST['opinion']];
    if (!isset($_POST['opinion'])) {
        array_push($errors, 'You must select one of the opinions');
    }
}

// Now generate the response page. The amount of PHP in what follows
// should be minimised and we should try to avoid embedding HTML in
// PHP literal strings in order that tools like Netbeans can parse
// the PHP and HTML separately. [Sometimes this goal has to be compromised
// however, in order to keep the code tolerably clean.]
// Later on we'll refer to the bit that follows as a view or,
// more likely, as two views, one for the thank you response and one
// for the main form presentation.

//Output the response page DOCTYPE, header etc
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Opinion page</title>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    </head>
        <body>
        <h1>My opinion of SENG365 so far</h1>
<?php
if ($isPostBack and empty($errors)) {
    ?>
        <p>
        <?php
            echo "Thanks, $username, for your opinion of SENG365 (namely \"$opinion\").";
        ?>
        </p>
 <?php
}
else {
    
    foreach ($errors as $error) {
        echo $error. "<br>";
    }
    ?>
    <form action="poll.php" method="post">
        <p>Username: <input type="text" name="username" value="<?php echo $username?>"></p>
        <p>Please choose the option that best describes your opinion of the
            SENG365 so far and click "Submit"</p>
        <?php
                $value = 0;
                foreach ($buttons as $opinions) {
                    echo "<input type='radio' name='opinion' value='$value'>$opinions<br>\n";
                    $value += 1;
                }
                ?>
        <p><input type="submit" value ="Submit"> </p>
    </form>
    <?php
}
?> 
</body>
</html>
