<?php
// Test GraphQL connection
$query = 'query { activeClubs { cid name category } }';
$data = json_encode(['query' => $query]);

$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => $data,
        'timeout' => 10
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false
    ]
];

$context = stream_context_create($options);
$result = @file_get_contents('https://clubs.iiit.ac.in/graphql', false, $context);

if ($result === FALSE) {
    $error = error_get_last();
    echo "ERROR: " . ($error['message'] ?? 'Unknown error') . "\n";
    exit(1);
}

echo "SUCCESS!\n";
echo "Response: " . substr($result, 0, 200) . "...\n";
$decoded = json_decode($result, true);
if (isset($decoded['data']['activeClubs'])) {
    echo "Found " . count($decoded['data']['activeClubs']) . " clubs\n";
}
?>
