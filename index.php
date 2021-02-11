<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Upload files</title>
</head>

<body>
    <div>
        <h1 class="m-3">Upload some files</h1>
        <form method="POST" enctype="multipart/form-data">
        <div class="m-3">
            <label for="file" class="form-label">Select image to upload: </label><br>
            <input class="form-file" type="file" id="file" name="uploadedName" accept="video/*,audio/*,image/*">
            <input class="form-btn" type="submit" value="Nahrát" name="submit" />
        </div>
        </form>
        <?php
        if ($_FILES) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["uploadedName"]["name"]);
            $fileType = strtolower(explode("/", $_FILES["uploadedName"]["type"])[0]);

            $uploadSuccess = true;

            if ($_FILES["uploadedName"]["error"] != 0) {
                echo "<p class='m-3'>Chyba při uploadu.</p>";
                $uploadSuccess = false;
            } elseif (file_exists($targetFile)) {
                echo "<p class='m-3'>Soubor již existuje.</p>";
                $uploadSuccess = false;
            } elseif ($_FILES["uploadedName"]["size"] > 8388608) {
                echo "<p class='m-3'>Soubor je příliš velký.</p>";
                $uploadSuccess = false;
            } elseif ($fileType !== "image" && $fileType !== "audio" && $fileType !== "video") {
                echo "<p class='m-3'>Soubor má špatný typ.</p>";
                $uploadSuccess = false;
            }

            if ($uploadSuccess) {
                if (move_uploaded_file($_FILES["uploadedName"]["tmp_name"], $targetFile)) {
                    $fileName = basename($_FILES["uploadedName"]["name"]);
                    echo "<p class='m-3'>Soubor " . $fileName . " se uploadnul na server.</p>";
                    if ($fileType === "image") {
                        echo "<img class='ml-3' src='$targetFile' alt='$fileName'>";
                    } else if ($fileType === "video") {
                        echo "<video class='ml-3' controls autoplay src='$targetFile' alt='$fileName'>";
                    } else {
                        echo "<audio class='ml-3' controls autoplay src='$targetFile' alt='$fileName'>";
                    }
                }
            }
        }
        ?>
    </div>
</body>

</html>