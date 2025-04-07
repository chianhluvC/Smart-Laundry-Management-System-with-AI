<?php
function queryDeepSeek($prompt) {
    $apiKey = 'OPENROUTER_API_KEY=your_new_api_key_here'; 
    $url = 'https://openrouter.ai/api/v1/chat/completions';

    $headers = [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ];

    $data = [
        "model" => "deepseek/deepseek-r1:free",
        "messages" => [
            [
                "role" => "user",
                "content" => $prompt
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);
    return $json['choices'][0]['message']['content'] ?? 'Không thể phản hồi.';
}
?>
