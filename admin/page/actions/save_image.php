<?php
$image = $_POST['image'];
$image = str_replace(' ','+',$image);
$image = substr($image, 22);
echo $image;
file_put_contents('../../../images/Created_Images/picture.png', base64_decode($image));

?>