<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$api_key = '';
$endpoint = 'https://api.openai.com/v1/chat/completions';

$data = array(
    'model' => 'gpt-3.5-turbo',
    'messages' => array(
        array('role' => 'system', 'content' => 'Você é um assistente de bate-papo.'),
        array('role' => 'user', 'content' => 'Conte-me uma piada.')
    )
);

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if ($result === null) {
    echo "Erro ao decodificar a resposta JSON da API.";
} else {
    if (isset($result['choices']) && !empty($result['choices'])) {
        $reply = $result['choices'][0]['message']['content'];
        echo "Resposta do GPT-3: " . $reply;
    } else {
        echo "Resposta da API não contém 'choices' ou está vazia:\n";
        echo "<pre>";
        var_dump($result);
        echo "</pre>";
    }
}

$reply = $result['choices'][0]['message']['content'];

echo "Resposta do GPT-3: " . $reply;

?>
