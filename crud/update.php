<?php 

function updateData($username, $oldData, $newData) {
    $filePath = "../database/pegawai.txt";
    $tempFilePath = "../database/temp_pegawai.txt"; // Temporary file for rewriting

    $inputFile = fopen($filePath, "r");  // Open original file for reading
    $outputFile = fopen($tempFilePath, "w"); // Open temporary file for writing

    if ($inputFile && $outputFile) {
        while (($line = fgets($inputFile)) !== false) {
            $line = trim($line);
            $line = trim($line, "[]");

            if (!empty($line)) {
                $data = explode(',', $line);

                if (in_array($oldData[1], $data) && in_array($username, $data)) {
                    
                    $str = implode(',', $newData);
                    $newStr = '[' . $username . "," . $str . "]\n";
                    fwrite($outputFile, $newStr); 
                } else {

                    fwrite($outputFile, "[" . $line . "]\n");
                }
            }
        }

        fclose($inputFile);
        fclose($outputFile);

        rename($tempFilePath, $filePath);

        echo "Data updated successfully!";
    } else {
        echo "Failed to open the file.";
    }
}

?>