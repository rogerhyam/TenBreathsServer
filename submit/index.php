
<?php
    ini_set('error_reporting', E_ALL);
    
    error_log(print_r($_POST, true) . "\n", 3, "../data/debug.log");
    error_log(print_r($_GET, true) . "\n", 3, "../data/debug.log");
    //error_log(http_get_request_body() . "\n", 3, "../data/debug.log");
    
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
       render_test_form();
       exit();
    }

    // are we uploading a file?
    if( isset($_FILES["file"]) ){
        
        move_uploaded_file($_FILES["file"]["tmp_name"], '../data/' . $_FILES["file"]["name"]);
        
        // fixme: check file size
        // fixme: check file type
        // fixme: check application id
    
        echo 0;
        
    }
    
    if(isset($_POST['survey'])){
        
        $now = time();
        
        // just write them to a file - will be written to 
        file_put_contents('../data/survey_' . $now . '.txt', $_POST['survey'] );
        file_put_contents('../data/surveyor_' . $now . '.txt', $_POST['surveyor'] );
        
        echo 0;
        
    }
    
    
function render_test_form(){
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ten Breaths Submit</title>
    <script src="https://code.jquery.com/jquery-2.1.4.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $( document ).ready(function() {
            $('#ajax-test').on('click', function(){
                $.post(
                    'index.php',
                    "survey=banana&surveyor=cake",
                    function(data){
                        console.log(data);
                        alert('Data saved');
                    }
                );
            });
        });
    </script>
</head>
<body>

<form action="index.php" method="POST" enctype="multipart/form-data">
    <h2>Select image to upload</h2>
    <input type="file" name="file" id="file"><br/>
    <input type="submit" value="Upload Image" name="submit">
</form>
<hr/>
<form action="index.php" method="POST" enctype="multipart/form-data">
    <h2>data to upload</h2  >
    Survey: <input type="text" name="survey" id="survey"/><br/>
    Surveyor: <input type="text" name="surveyor" id="surveyor"/><br/>
    <input type="submit" value="Submit" name="submit">
</form>
<hr/>
<button id="ajax-test">Ajax Test</button>


</body>
</html>

<?php
}
?>