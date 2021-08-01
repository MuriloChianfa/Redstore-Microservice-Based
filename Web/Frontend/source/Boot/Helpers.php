<?php

if (!extension_loaded('curl')) {
    throw new Exception("Curl não suportado!", 1);
    exit;
}

function site(string $param = null): string {
    if($param && !empty(SITE[$param])) {
        return SITE[$param];
    }

    return SITE["root"];
}

/**
 * @param string $path
 * @return string
 */
function url(string $path = null): string
{
    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

function routeImage(string $imageUrl): string {
    return "https://via.placeholder.com/1200x628/0984e3/FFFFFF?text={$imageUrl}";
}

function asset(string $path, $time = true): string {
    return SITE["root"] . "/views/assets". $path;
}

function flash(string $type = null, string $message = null): ?string {
    if($type && $message) {
        $_SESSION["flash"] = [
            "type" => $type,
            "message" => $message
        ];
        return null;
    }

    if(!empty($_SESSION["flash"]) && $flash = $_SESSION["flash"]) {
        unset($_SESSION["flash"]);
        return "<div class=\"message {$flash["type"]}\">{$flash["message"]}</div>";
    }

    return null;
}

/**
 * ################
 * ###   DATE   ###
 * ################
 */

/**
 * @param string $date
 * @param string $format
 * @return string
 */
function date_fmt(string $date = "now", string $format = "d/m/Y H\hi"): string
{
    return (new DateTime($date))->format($format);
}

/**
 * @param string $date
 * @return string
 */
function date_fmt_br(string $date = "now"): string
{
    return (new DateTime($date))->format(CONF_DATE_BR);
}

/**
 * @param string $date
 * @return string
 */
function date_fmt_app(string $date = "now"): string
{
    return (new DateTime($date))->format(CONF_DATE_APP);
}

function callAPI(string $url, string $method, $data = null, string $jwt = null)
{
    $curl = curl_init(BASE_API . $url); // Montar url da API
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Desligar a verificação do TLS
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // Desligar a verificação do TLS
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Obter retorno em $resultado // remover var_dump automatico

    $headers = [];

    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Definir corpo
        $headers[] = 'Content-Type:multipart/form-data';
    }

    if (!empty($jwt)) {
        $jwt = "Authorization: Bearer {$jwt}";
        $headers[] = $jwt;
    }

    if (!empty($headers)) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); // Setar HEADER como json
    }

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); // Definir metodo
    
    $resultado = curl_exec($curl); 
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);

    curl_close($curl);

    if ($curlError) {
        return ["curl_error" => $curlError];
    }

    return [
        "result" => $resultado,
        "code" => $httpCode
    ];
}
