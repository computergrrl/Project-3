<?php
require('inc/connection.php');
include('inc/functions.php');


if(!empty($_POST)) {
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
$time_spent = filter_input(INPUT_POST, 'time_spent', FILTER_SANITIZE_STRING);
$entry = filter_input(INPUT_POST, 'entry', FILTER_SANITIZE_STRING);
$link_name = filter_input(INPUT_POST, 'link_name', FILTER_SANITIZE_STRING);
$link_address = filter_input(INPUT_POST, 'link_address', FILTER_SANITIZE_URL);
$notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);

if($title == null || $date == null || $time_spent == null || $entry == null) {
     // echo "<h2>Please enter all required fields</h2>";
     echo '<script>alert("Please enter all required fields : Title, date, time spent and entry");</script>';

}

elseif(new_entry($title, $date, $time_spent, $entry, $link_name, $link_address, $notes)) {
    header('location:index.php');
}  else {
  echo "<h1>Could not add entry</h1>";
}

}

include('inc/header.php');
?>
        <section>
            <div class="container">
                <div class="new-entry">
                    <h2>New Entry</h2>
                    <h5>* indicates required field</h5>
                    <br>
                    <form method="post" action="new.php">
                        <label for="title"> Title *</label>
                        <input id="title" type="text" name="title"><br>
                        <label for="date">Date *</label>
                        <input id="date" type="date" name="date"><br>
                        <label for="time-spent"> Time Spent *</label>
                        <input id="time_spent" type="text" name="time_spent"><br>
                        <label for="what-i-learned">What I Learned *</label>
                        <textarea id="entry" rows="5" name="entry"></textarea>
                        <fieldset>
                          <legend>Resources to remember:</legend>
                          <legend>Enter web link and any additional notes for future reference:</legend>
                        <label for="link_name">Enter name for link:</label>
                        <input id="link_name" type="text" name="link_name">
                        <label for="link_address">Enter web link here:</label>
                        <input id="link_address" type="text" name="link_address">
                        <textarea rows="3" name="notes" id="notes"></textarea>
                      </fieldset>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="#" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
        <?php include('inc/footer.php'); ?>
    </body>
</html>
