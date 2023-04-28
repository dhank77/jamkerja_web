<?php

function send_onesignal($sql, $data, $title, $message)
{
    try {
        $dataUser = array();
        foreach ($sql as $row) {
            array_push($dataUser, $row);
        }

        $content = array(
            'en' => $message
        );

        $heading = array(
            'en' => $title
        );

        $fields = array(
            'app_id' => 'e286c21c-5f18-4464-bbc0-4a944b7ba371',
            'include_player_ids' => $dataUser,
            'data' => array('uniqueId' => $data),
            'contents' => $content,
            'headings' => $heading,
            'large_icon' => '@mipmap/ic_launcher',
        );

        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic NjJlZWUyMGEtNjczMi00NmExLTlmNTktZWZiODU0NWQzMTEz'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
    } catch (\Throwable $th) {
        echo $th;
    }
}

function send_wa($no_hp, $pesan)
{

    if($no_hp != ""){
        try {
$message = 'INFO! SBC ABSENSI:
------------------------------------------------
' . $pesan . '
------------------------------------------------
Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem
Mohon untuk tidak dibalas karena tidak akan direspon oleh sistem
------------------------------------------------';
    
            $no_hp = nomor_wa($no_hp);
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://web.wa-gateway.site/api/send-message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'name' => 'Andang',
                    'receiver' => $no_hp,
                    'message' => $message
                ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            return json_decode($response);
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}

function nomor_wa($telepon)
{
    $telepon = str_replace(" ", "", str_replace("-", "", $telepon));

    if (strpos($telepon, '/') !== false) {
        $ex = explode('/', $telepon);
        $telepon = $ex[0];
    }

    return $telepon;
}

function telat_sore($tanggalIn, $jam_tepat_pulang)
{
    if ($tanggalIn != "") {
        // Pengurangan Cepat Pulang Selain Jumat
        if (strtotime($tanggalIn) < strtotime(date("Y-m-d", strtotime($tanggalIn)) . $jam_tepat_pulang)) {
            $dateTimeObject1 = date_create(date("Y-m-d", strtotime($tanggalIn)) . " " . $jam_tepat_pulang);
            $dateTimeObject2 = date_create($tanggalIn);

            $difference = date_diff($dateTimeObject1, $dateTimeObject2);

            $telat_sore = $difference->h * 60;
            $telat_sore += $difference->i;
            return $telat_sore;
        }
        return 0;
    }
}
