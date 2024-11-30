<?php
// Get the raw POST data
$input = file_get_contents('php://input');

// Decode the JSON payload
$data = json_decode($input, true);

if (isset($data['row'])) {
    // Decode the row data (if it's JSON)
    $rowData = json_decode($data['row'], true);

    if ($rowData) {
        // Store the row data in a session or process it as needed
        session_start();
        $_SESSION['row_data'] = $rowData;

        // Respond to the client
        echo json_encode(['status' => 'success', 'message' => 'Row data stored.', 'data' => $rowData]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid row data.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received.']);
}
?>
