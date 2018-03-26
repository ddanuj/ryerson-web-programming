<?php
//read the cookie
if(isset($_COOKIE['visitTime']))
{
setcookie('visitTime', date("F jS Y - H:i "), time()-3600);
setcookie('visitTime', date("F jS Y - H:i "), time()+3600);
echo "Welcome!! last time of your visit is: ".$_COOKIE['visitTime']."<br />";
}
else
{
setcookie('visitTime', date("F jS Y - H:i "), time()+3600);
echo "Welcome!! this is your first time to visit<br />";
}


/*display files in a table 
first column in image with link to video
second column is the text description*/

$dir = "../php_up";

//get all video files
$video_files = glob("$dir/*.{mp4,webm,ogg}", GLOB_BRACE );
//print_r($video_files);

//get all image files
$picture_files = glob("$dir/*.{jpg,jpeg,png}", GLOB_BRACE);
//print_r($picture_files);


//get all text files
$text_files = glob("$dir/*.{txt,doc,docx}", GLOB_BRACE);
//print_r($text_files);


//display files in table
echo "<!DOCTYPE html><head><title>Assignment 2</title><link rel=\"stylesheet\" type=\"text/css\" href=\"style_render.css\" /></head><body>";
echo "<h1>Check out the videos !!</h1>";
echo "<table>";
for( $i = 0 ; $i < count($video_files) ; $i ++ ){
echo "<tr>";

echo "<td>";
//echo "$picture_files[$i]";
echo "<video width=\"500\" height=\"400\" poster='$picture_files[$i]' Controls>;<source src='$video_files[$i]' type=\"video/mp4\">";
//echo "";
echo "<source src=\"$video_files[$i]\" type=\"video/webm\">";
echo "<source src=\"$video_files[$i]\" type=\"video/ogg\">";
echo "video not suppoted in your browser";
echo "</video>";

$textcontents = file_get_contents("$text_files[$i]");
echo "<h3>$textcontents</h3>";
echo "</td>";

echo "</tr>";
}
echo "</table></body></html>";
?>
