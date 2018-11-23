<?php

require_once "models/UserDAO.php";

function postSignup($request, $response, $args) {
    $code = OK;
    $message = 'Success';
    $req = $request->getParams();
    $userDAO = new UserDAO();
    $arrRow = null;
    $isEmailExist = $userDAO->isEmailExist($req['email']);

    if ($isEmailExist) {
        $code = STATUS_CONFLICT;
        $message = 'Email id already exist!';
    } else {
        $userDAO->signup($req);

        $arrRow = $userDAO->getUserByEmail($req['email']);
        if (empty($arrRow)) {
            $arrRow = null;
            $code = STATUS_INTERNAL_SERVER_ERROR;
            $message = 'Some thing went wrong. Please try later.';
        } else {
            $arrRow['user_token'] = generateToken($arrRow['id'], $arrRow['email'], $req['device_id']);
            $userDAO->updateToken($arrRow['id'], $arrRow['user_token'], $req['device_id']);
        }
    }
    sendResponse($arrRow, $code, $message);
}

function postLogin($request, $response, $args) {
    $code = OK;
    $message = 'Success';
    $req = $request->getParams();
    $userDAO = new UserDAO();
    $arrRow = $userDAO->getLoginByCreds($req['email'], $req['password']);

    if (empty($arrRow)) {
        $arrRow = null;
        $code = STATUS_UNAUTHORIZED;
        $message = 'Incorrect username or password.';
    } else {
        $arrRow['user_token'] = generateToken($arrRow['id'], $arrRow['email'], $req['device_id']);
        $userDAO->updateToken($arrRow['id'], $arrRow['user_token'], $req['device_id']);
    }
    sendResponse($arrRow, $code, $message);
}

function getProfile($request, $response, $args) {
    $userDAO = new UserDAO();
    $user_id = $args['user_id'];
   
    $arrRow = $userDAO->getUserById($user_id);
    
    sendResponse($arrRow);
}
