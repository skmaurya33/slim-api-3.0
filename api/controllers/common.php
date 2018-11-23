<?php
require_once "models/CommonDAO.php";
function pre($data) {
    echo '<pre>';
    print_r($data);
    die;
}

function logError($errorMessage) {
    error_log("\r\n" . date('Y-m-d H:i:s') . ': ' . $errorMessage, 3, BASE_PATH . "errors.log");
}

function getUploadsUrl($path = '') {
    return UPLOADS_URL . $path;
}

function getResponse($data, $code, $message, $metadata) {
    $metadata = empty($metadata) ? null : $metadata;
    $data = empty($data) ? null : $data;

    $response['code'] = $code;
    $response['message'] = $message;
    $response['metadata'] = $metadata;
    $response['data'] = $data;
    return $response;
}

function sendResponse($data = array(), $code = STATUS_OK, $message = "Success", $metadata = array()) {
    echo json_encode(getResponse($data, $code, $message, $metadata), true);
    die;
}

function generateToken($userid, $email, $device_id) {
    $str = time() . $userid . $email . $device_id;
    return md5($str);
}

function openRequest($request, $response, $args, $method) {
    try {
        $method($request, $response, $args);
    } catch (Exception $e) {
        logError($e->getMessage());
        sendResponse(array(), STATUS_INTERNAL_SERVER_ERROR, $e->getMessage());
    }
}

function tokenRequest($request, $response, $args, $method) {
    try {
        $headers = $request->getHeaders();
        $token = trim($headers['HTTP_TOKEN'][0]);
        $commonDAO = new CommonDAO();
        $tokenRow = array();
        if ($token != '') {
            $tokenRow = $commonDAO->getUserByToken($token);
        }

        if (!empty($tokenRow)) {
            $args['user_id'] = $tokenRow['id'];
            $method($request, $response, $args);
        } else {
            sendResponse(array(), STATUS_UNAUTHORIZED, 'Invalid token!');
        }
    } catch (Exception $e) {
        logError($e->getMessage());
        sendResponse(array(), STATUS_INTERNAL_SERVER_ERROR, $e->getMessage());
    }
}
