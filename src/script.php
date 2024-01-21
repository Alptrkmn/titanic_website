<?php
try {
    $data = json_decode(file_get_contents('php://input'), true);
    error_log("Received Data: " . print_r($data, true));

    $prediction = $data['prediction'];

    $result = ($prediction > 0.5) ? 'Alive' : 'Dead';

    error_log("Prediction Result: " . $result);

    echo json_encode(['result' => $result]);
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());

    http_response_code(500);  
    echo json_encode(['error' => $e->getMessage()]);
}
?>
