<?php
//set the visit time cookie
if(!isset($_COOKIE['visitTime'])){
echo "Welcome!! This is your first time to visit";
}

setcookie(visitTime, time(), 5184000+time());

function uploadFile($file,$new_file_name){
$up_path = "/home/ddanujx1/public_html/php_up/".$new_file_name;
//$up_path = $up_path.basename($_FILES["$upfile"]["name"]);

//echo $upfile;
if(move_uploaded_file($_FILES["$file"]["tmp_name"],$up_path)){
echo "the file".$new_file_name." is uploaded !<br />";}
else{exit("error in uploading".$new_file_name);}

}

// get the file handles
$video_name = $_FILES['video']['name'];
$picture_name = $_FILES['picture']['name'];
$text_name = $_FILES['text']['name'];

//checking for the valid files
function explodeFile($file_name){

$file_chunks = explode(".",$file_name);
return $file_chunks;
}

$video_chunks = explodeFile($video_name);
$video_ext = end($video_chunks);
//check for the valid video file
if( !(($video_ext == "mp4") || ($video_ext == "webm") || ($video_ext == "ogg")) ){
exit ("upload valid video file - Only mp4, webm, ogg file extensions allowed");
}

$picture_chunks = explodeFile($picture_name);
$picture_ext = end($picture_chunks);
//check for the valid image file
if( !(($picture_ext == "jpg") || ($picture_ext == "jpeg") || ($picture_ext == "png")) ){
exit ("upload valid image file - Only jpg, jpeg, png file extensions allowed");
}

$text_chunks = explodeFile($text_name);
$text_ext = end($text_chunks);
//check for the valid text file
if( !($text_ext == "txt")){
exit ("upload valid video file - Only txt file extension allowed");
}

//if program flow is here means files are valid ! now change their names to the video file name
$new_video_name = $video_name;
$new_picture_name = $video_chunks[0].'.'.$picture_ext;
$new_text_name = $video_chunks[0].'.'.$text_ext;


//function to sort an array using date of moddification
function sortByDate ($arr){
array_multisort( array_map('filemtime',$arr) , SORT_NUMERIC , SORT_DESC , $arr);
return $arr;
//code refers to http://www.computing.net/answers/webdevel/php-sort-directory-contents-by-date/3483.html
}

//before uploading files to pemanent location, check whether folder capacity is full
function deleteOldFiles (){
$dir = "../php_up";
$video_files = glob("$dir/*.{mp4,webm,ogg}", GLOB_BRACE );//video files
//print_r ($video_files);echo "<br />";
$picture_files = glob("$dir/*.{jpg,jpeg,png}", GLOB_BRACE);//pictures
//print_r ($picture_files);echo "<br />";
$text_files = glob("$dir/*.{txt,doc,docx}", GLOB_BRACE);//all text files
//print_r ($text_files);echo "<br />";

//sort the arrays according to the date of modification
$new_vid = sortByDate($video_files);
$new_img = sortByDate($picture_files);
$new_text = sortByDate($text_files);

$cnt = count($video_files);

//delete oldest files if there are more than 5 files in the folder
if($cnt>4){
unlink(end($new_vid));
unlink(end($new_img));
unlink(end($new_text));
}
}
//move the files from temporary storage to permanent location
deleteOldFiles();
uploadFile("video",$new_video_name);
uploadFile("picture",$new_picture_name);
uploadFile("text",$new_text_name);

echo "<html>";
echo "<head>";
echo "<meta http-equiv=\"refresh\" content=\"0;url=http://ddanuj.x10.mx/ass2-php/render.php\">";
echo "</head>";
echo "</html>";
?>
