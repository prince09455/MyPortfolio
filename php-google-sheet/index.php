<?php
function myGetVisIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function sendtoSheet($sheet_name, $name, $email = 'No EMAIL', $phone, $source)
{
    require __DIR__ . '/vendor/autoload.php';

    // Setup Authentication
    $client = new Google_Client();
    $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    $client->setAccessType('offline');
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $service = new Google_Service_Sheets($client);

    $spreadsheetId = '1kczIYH5qKlUazg7-o8QGftWs13KaWJ7a9fGsTc124Ns';

    date_default_timezone_set('Asia/Kolkata');
    $date = time();
    $leadDatetime = date('l jS \of F Y h:i:s A');

    // Values and Sheet Range
    $ip_location = myGetVisIpAddr();
    $range = $sheet_name . '!A:E';
    $values = [[$leadDatetime, $name, $email, $phone, $source, $ip_location]];

    $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
    $params = ['valueInputOption' => 'RAW'];
    $result = $service->spreadsheets_values->append(
        $spreadsheetId,
        $range,
        $body,
        $params
    );
}
