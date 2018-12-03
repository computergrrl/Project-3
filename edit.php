<?php
require('inc/connection.php');
include('inc/functions.php');

$q = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);


if($_SERVER['REQUEST_METHOD'] == 'POST') {
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
$time_spent = filter_input(INPUT_POST, 'time_spent', FILTER_SANITIZE_STRING);
$entry = filter_input(INPUT_POST, 'entry', FILTER_SANITIZE_STRING);
$link_name = filter_input(INPUT_POST, 'link_name', FILTER_SANITIZE_STRING);
$link_address = filter_input(INPUT_POST, 'link_address', FILTER_SANITIZE_URL);

  if(update_entry($title, $date, $time_spent, $entry,
  $link_name = null, $link_address = null, $q)) {
      header('location:index.php');
  }

  }

$q--;
$get_id = $journals[$q];



include('inc/header.php');
?>
        <section>
            <div class="container">
                <div class="edit-entry">
                    <h2>Edit Entry</h2>
                      <?php echo '<form action="edit.php?q=' .($q +1) .'" method="post">'; ?>
                        <label for="title">Title</label>
                        <input id="title" type="text" name="title" value="<?php echo $get_id['title'];?>"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date" value="<?php echo $get_id['date'];?>"><br>
                        <label for="time_spent" > Time Spent</label>
                        <input id="time_spent" type="text" name="time_spent" value="<?php echo $get_id['time_spent'];?>">><br>
                        <label for="entry">What I Learned</label>
                        <textarea id="entry" rows="5" name="entry"><?php echo $get_id['entry'];?></textarea>
                        <fieldset>
                          <legend>Resources to remember:</legend>
                          <legend>Save a web link for later reference</legend>
                        <label for="link_name">Enter name for link:</label>
                        <input id="link_name" type="text" name="link_name" value="<?php echo $get_id2['link_name'];?>">>
                        <label for="link_address">Enter web link here:</label>
                        <input id="link_address" type="text" name="link_address" value="<?php echo $get_id2['link_address'];?>">>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="#" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
        <?php include('inc/footer.php'); ?>
    </body>
</html>
