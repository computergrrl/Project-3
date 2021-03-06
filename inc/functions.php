<?php
//1st query - used to access journal table
    try {
              $sql = "SELECT * FROM journal";
              $results = $db->prepare($sql);
              $results->execute();
              $journals =  $results->fetchAll(PDO::FETCH_ASSOC);
          }  catch (Exception $e) {
        echo "Bad request from query 1: " . $e->getMessage();
        exit;
    }
//2nd query - used to access resources table
      try {  $sql2 = "SELECT link_id, link_name, link_address, notes, resources.journal_id
         FROM resources JOIN journal ON journal.journal_id = resources.journal_id";
              $getResources = $db->prepare($sql2);
              $getResources->execute();
              $resources = $getResources->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
            echo "Bad request from query 2: " . $e->getMessage();
            exit;
      }

//function used to show list of entries on index page that are
//sorted by date  (descending)
function list_entries() {
    include('connection.php');
  try {
         return $db->query("SELECT * FROM journal ORDER BY date DESC");

        }  catch (Exception $e) {
      echo "Error: " . $e->getMessage();
      exit;
  }
  return array();

}

//function for adding new entries
function new_entry($title, $date, $time_spent, $entry, $link_name = null, $link_address = null, $notes = null) {

        include('connection.php');
//first prepare statement - to add required fields to journal table
$newEntry1 = "INSERT INTO journal(title, date, time_spent, entry)
                  VALUES(?, ?, ?, ?)" ;
                try {
                      $results = $db->prepare($newEntry1);
                      $results->bindValue(1, $title, PDO::PARAM_STR);
                      $results->bindValue(2, $date, PDO::PARAM_STR);
                      $results->bindValue(3, $time_spent, PDO::PARAM_STR);
                      $results->bindValue(4, $entry, PDO::PARAM_STR);
                      $results->execute();
                      //return the id of the last entry so that the correct 'journal_id' is
                      //added to both tables
                      $id = $db->lastInsertId();
                    }   catch (Exception $e) {
                          echo "Unable to add entry1 <br />" . $e->getMessage();
                          return false;
                  }
//2nd prepare statement to add optional fields to resource table
  $newEntry2 = "INSERT INTO resources(link_name, link_address, notes, journal_id) VALUES (?, ?, ?, ?)";

                   try {
                     $the_resources = $db->prepare($newEntry2);
                     $the_resources->bindValue(1, $link_name, PDO::PARAM_STR);
                     $the_resources->bindValue(2, $link_address, PDO::PARAM_STR);
                     $the_resources->bindValue(3, $notes, PDO::PARAM_STR);
                     $the_resources->bindValue(4, $id, PDO::PARAM_INT);
                     $the_resources->execute();

                   }  catch (Exception $e)  {
                         echo "Unable to add entry2 <br />" . $e->getMessage();
                         return false;
                   }

        return true;
}
//function for editing an entry
function update_entry($title, $date, $time_spent, $entry, $link_name = null, $link_address = null, $notes = null, $q) {

    include('connection.php');

//first prepare statement - to update journal table
  $sql = "UPDATE journal SET title = ?, date = ?, time_spent = ?, entry = ?
            WHERE journal_id = ?";

//2nd prepare statement to update optional fields to resource table
  $sql2 = "UPDATE resources SET link_name = ?, link_address = ?, notes = ?, journal_id = ?  WHERE journal_id = ?";

                  try {
                    $results = $db->prepare($sql);
                    $results->bindValue(1, $title, PDO::PARAM_STR);
                    $results->bindValue(2, $date, PDO::PARAM_STR);
                    $results->bindValue(3, $time_spent, PDO::PARAM_STR);
                    $results->bindValue(4, $entry, PDO::PARAM_STR);
                    $results->bindValue(5, $q, PDO::PARAM_INT);

                    $results->execute();

                      }   catch (Exception $e) {
                        echo "Unable to add newentry1 <br />" . $e->getMessage();
                        return false;
           }

                 try {
                    $results2 = $db->prepare($sql2);
                    $results2->bindValue(1, $link_name, PDO::PARAM_STR);
                    $results2->bindValue(2, $link_address, PDO::PARAM_STR);
                    $results2->bindValue(3, $notes, PDO::PARAM_STR);
                    $results2->bindValue(4, $q, PDO::PARAM_INT);
                    $results2->bindValue(5, $q, PDO::PARAM_INT);

                    $results2->execute();
                  }  catch (Exception $e)  {
                        echo "Unable to add newentry2 <br />"
                        . $e->getMessage();
                        return false;
        }
          return true;
 }

//function for deleting an entry
function delete_entry($entry_id) {
    include('connection.php');

    $sql = "DELETE FROM journal WHERE journal_id = ?";
    $sql2 = "DELETE FROM resources WHERE journal_id = ?";
              try {
                $results = $db->prepare($sql);
                $results->bindValue(1, $entry_id, PDO::PARAM_INT);

                $results->execute();

                  }   catch (Exception $e) {
                    echo "Unable to delete entry1 <br />" . $e->getMessage();
                    return false;
            }

             try {
                $results2 = $db->prepare($sql2);
                $results2->bindValue(1, $entry_id, PDO::PARAM_INT);

                $results2->execute();
              }  catch (Exception $e)  {
                    echo "Unable to delete entry2 <br />"
                    . $e->getMessage();
                    return false;
            }
return true;

}
