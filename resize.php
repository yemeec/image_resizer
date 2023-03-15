<?php
//  include 'config.php';

 function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.html' ?>
  <body>

    <?php include 'nav.html' ?>
  <!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('assets/img/page-header.jpg');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-12 text-center">
            <h2>Resize and Compress your image</h2>
            </div>
          </div>
        </div>
      </div>
      
    </div><!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">


        <div class="row gy-4 mt-4">

        <center>
        
        <div class="col-lg-8">
        <h5>Upload the Image </h5>
        
        <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" >
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="number" name="height" class="form-control" placeholder="specify height" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="number" class="form-control" name="width"  placeholder="specify width" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="file" class="form-control" name="file" id="subject" placeholder="" required>
              </div>
                            
              <div class="form-group mt-3 text-center">
                <button type="submit" name="Submit1"  class="btn btn-info">Resize Image</button>
              </div>
            </form>

            <?php 

define ("MAX_SIZE","4000");

$errors=0;

if($_SERVER["REQUEST_METHOD"] == "POST")
{

  // check if inputs are not empty
 $image =$_FILES["file"]["name"];
 $width1= $_POST['width'];
 $height1=$_POST['height'];

$uploadedfile = $_FILES['file']['tmp_name'];

// if image is uploaded
 if ($image) 
 {
// check the extenion of file uploaded
 $filename = stripslashes($_FILES['file']['name']);
 $extension = getExtension($filename);
 $extension = strtolower($extension);
if (($extension != "jpg") && ($extension != "jpeg") 
&& ($extension != "png") && ($extension != "gif")) 
 {
echo ' Unknown Image extension ';

$errors=1;
 }
else
{
  $size=filesize($_FILES['file']['tmp_name']);
// check if the size is too big
if ($size > MAX_SIZE*1024)
{
echo "You have exceeded the size limit";

$errors=1;
}

if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
// get the original size of the image
list($width,$height)=getimagesize($uploadedfile);
// implement the new size specified by user
$newwidth=$width1 ;
$newheight=$height1;

// $newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,
$width,$height);

// save the new resized image
$path = "passport/". $_FILES['file']['name'];
$filename = "passport/small". $_FILES['file']['name'];



imagejpeg($tmp,$filename,100);

}
}
}
//If no errors registred, print the success message

if(isset($_POST['Submit1']) && !$errors) 
{

echo"<div class='alert alert-primary' role='alert'>
Image resized sucessfully <a href='".$filename."' download >click to download</a>
</div>";
}


?>   
          </div><!-- End Contact Form -->

          </center>
        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
  <!-- End #main -->
  <?php include 'footer.html' ?>
   