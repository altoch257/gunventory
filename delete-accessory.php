<?php
    require_once 'includes/dbh.inc.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sqlStr =  "UPDATE Accessories SET Status = 'I' WHERE Id = $id";
        
        $stmt = $db->prepare($sqlStr);
        
        $result = $stmt->execute();
    
        if ($result) {
            echo '
              <script>
                alert("Accessory deleted.");
                history.back();
              </script>';
        }
        else {
            echo "Failed to delete record. Please try again.";
        }
    }
    
?>