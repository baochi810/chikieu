<?php
/**
 * Created by PhpStorm.
 * User: KieuNguyen
 * Date: 7/21/14
 * Time: 9:25 PM
 */
include_once 'common/DBConnector.php';
include_once 'common/header.php';

$result = mysqli_query($connection,"SELECT * FROM CKKaraoke");
?>


<div class='midle-center'>

<center>
<table border="1" style="width:300px">
<tr>
  <td>STT</td>
  <td>Ten Bai Hat</td>
  <td>Ma So</td>

  
</tr>

<?php
  while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
 echo "<tr>";
  echo "<td>" . $row['karaokeid'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['code'] . "</td>";

  echo "</tr>";
}
  ?>

</table> 
</center>
</div>

<?php
include_once 'common/footer.php';
?>