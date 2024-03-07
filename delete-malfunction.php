<?php
    require_once 'includes/dbh.inc.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sqlStr =  "UPDATE Malfunctions SET Status = 'I' WHERE Id = $id";
        
        $stmt = $db->prepare($sqlStr);
        
        $result = $stmt->execute();
    
        if ($result) {
            echo '
              <script>
                alert("Malfunction record deleted.");
                history.back();
              </script>';
        }
        else {
            echo "Failed to delete record. Please try again.";
        }
    }
    
?>