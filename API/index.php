<?php 
include_once("functions.php");
include_once("find_token.php");
include_once("error_handler.php");

if(preg_match_all("/^add_player$/ui", $_GET['type'])){
    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['role_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр role_id!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "INSERT INTO `player`(`name`, `role_id`) VALUES ('".$_GET['name']."', ".$_GET['role_id'].")";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit($query);
    }
    
    echo ajax_echo(
        "Успех!",
        "Игрок добавлен",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^add_match$/ui", $_GET['type'])){
    if(!isset($_GET['match_name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр match_name!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "INSERT INTO `matches`(`match_name`) VALUES ('".$_GET['match_name']."')";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit($query);
    }
    
    echo ajax_echo(
        "Успех!",
        "Матч добавлен",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^add_trainer$/ui", $_GET['type'])){
    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "INSERT INTO `trainers`(`name`) VALUES ('".$_GET['name']."')";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit($query);
    }
    
    echo ajax_echo(
        "Успех!",
        "Треннер добавлен",
        false,
        "SUCCESS"
    );
    exit;
}


else if(preg_match_all("/^update_player$/ui", $_GET['type'])){
    if(!isset($_GET['player_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр player_id!",
            "ERROR",
            null
        );
        exit;
    }

    $name = '';
    if(isset($_GET['name'])){
        $name = "`name` = '".$_GET['name']."',";
    }
    $role_id = '';
    if(isset($_GET['role_id'])){
        $role_id = "`role_id`=".$_GET['role_id'].",";
    }
    $deleted = 'false';
    if(isset($_GET['deleted'])){
        $deleted = $_GET['deleted'];
    }

    $query = "UPDATE `player` SET ".$name.$role_id."`deleted`=".$deleted." WHERE `id`=".$_GET['player_id'];
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            "ERROR",
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Игрок изменен",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^update_match$/ui", $_GET['type'])){
    if(!isset($_GET['match_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр match_id!",
            "ERROR",
            null
        );
        exit;
    }

    $match_name = '';
    if(isset($_GET['match_name'])){
        $match_name = "`match_name` = '".$_GET['match_name']."',";
    }
    $deleted = 'false';
    if(isset($_GET['deleted'])){
        $deleted = $_GET['deleted'];
    }

    $query = "UPDATE `matches` SET ".$match_name." `deleted`=".$deleted." WHERE `id`=".$_GET['match_id'];
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            "ERROR",
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Матч изменен",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^update_trainer$/ui", $_GET['type'])){
    if(!isset($_GET['trainer_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр trainer_id!",
            "ERROR",
            null
        );
        exit;
    }

    $name = '';
    if(isset($_GET['name'])){
        $name = "`name` = '".$_GET['name']."',";
    }
    $deleted = 'false';
    if(isset($_GET['deleted'])){
        $deleted = $_GET['deleted'];
    }

    $query = "UPDATE `trainers` SET ".$name."`deleted`=".$deleted." WHERE `id`=".$_GET['trainer_id'];
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            "ERROR",
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Треннер изменен",
        false,
        "SUCCESS"
    );
    exit;
}


else if(preg_match_all("/^list_players$/ui", $_GET['type'])){

    $query = "SELECT * FROM `player` WHERE `deleted`=false";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список игроков выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}

else if(preg_match_all("/^list_matches$/ui", $_GET['type'])){
    $query = "SELECT * FROM `matches` WHERE `deleted`=false";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список матчей выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}

else if(preg_match_all("/^list_trainers$/ui", $_GET['type'])){

    $query = "SELECT * FROM `trainers` WHERE `deleted`=false";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список треннеров выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}

else if(preg_match_all("/^squad_for_match$/ui", $_GET['type'])){
    if(!isset($_GET['match_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр match_id!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "SELECT * FROM `player` WHERE id IN (SELECT `player_id` FROM `squad_for_match` WHERE `match_id`=".$_GET['match_id'].")";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список игроков на матч выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}

else if(preg_match_all("/^list_roles$/ui", $_GET['type'])){
    $query = "SELECT * FROM `roles` WHERE `deleted`=false";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список ролей выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}
