<?php
/* The "Thank you for your response" view.
 * Parameters: $title - the page title (for use by the header)
 *             $successMessage - the message to display.
 */

require('headerview.php');
?>

<h1>Thank you</h1>
<p>
    <?php echo $successMessage; ?>
</p>

<?php
require('footerview.php');

