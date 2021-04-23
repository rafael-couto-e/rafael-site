<?php
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/graduationcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/graduationdao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/graduation.class.php';
include_once '../../common/model/apimodel.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/resources/strings.php';
include_once '../../common/util/messageutil.class.php';

// VALIDATE AUTH HEADERS
header('Content-type: application/json');
$controller = new GraduationController(new PDOConnection());

// RETURNS THE SELECTED TYPE DATA
if (isset($_GET['graduationImage'])) {
    $model = new ApiModel();
    $code = 200;

    if (isset($_FILES['formData'])) {
        $file = $_FILES['formData'];

        if (!$controller->validFile($file)) {
            $code = 400;
            $model->error = MessageUtil::errorMessage(INVALID_GRADUATION_IMAGE);
        } else {
            $url = $controller->saveTempFile($file);
            $model->data = $url;
        }
    } else {
        $code = 400;
        $model->error = MessageUtil::errorMessage(INVALID_GRADUATION_IMAGE);
    }

    http_response_code($code);
    $model->success = $code == 200;
    $model->code = $code;

    echo $model->toJson();

    return;
}