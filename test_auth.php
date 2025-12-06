<?php
echo "Testing login endpoint...\n";

$postData = [
    'nomor' => '152022001',
    'password' => 'admin123'
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($postData)
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents('http://localhost:8080/api/auth/login', false, $context);

if ($result === FALSE) {
    echo "Error: Could not connect to the login endpoint\n";
} else {
    echo "Login response:\n";
    echo $result . "\n\n";
    
    // Try to decode the JSON response
    $response = json_decode($result, true);
    
    if (isset($response['data']['token'])) {
        $token = $response['data']['token'];
        echo "Token received: " . $token . "\n\n";
        
        // Test profile endpoint with the token
        echo "Testing profile endpoint...\n";
        
        $options = [
            'http' => [
                'header'  => "Authorization: Bearer " . $token . "\r\n",
                'method'  => 'GET'
            ]
        ];
        
        $context  = stream_context_create($options);
        $profileResult = file_get_contents('http://localhost:8080/api/auth/profile', false, $context);
        
        if ($profileResult === FALSE) {
            echo "Error: Could not connect to the profile endpoint\n";
        } else {
            echo "Profile response:\n";
            echo $profileResult . "\n";
        }
    } else {
        echo "No token received in login response\n";
    }
}