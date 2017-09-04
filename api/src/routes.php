<?php
// Routes
include("localDB.php");

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

//get Employees List
// $app->get('/getEmpList', function ($request, $response, $args) {
// 	$db = $this->db_local;
// 	$sql = "SELECT * FROM "
// });

//get Employees List
$app->post('/addEmployee', function ($request, $response) {
   
   try{
       $db = $this->db_local;
       $sql = "INSERT INTO `users`(`username`,`user_role`,`password`) VALUES (:username,:user_role,:password)";
       $pre  = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':username' => $request->getParam('username'),
       ':user_role' => $request->getParam('user_role'),
		//Using hash for password encryption
       'password' => password_hash($request->getParam('password'),PASSWORD_DEFAULT)
       );
       $result = $pre->execute($values);
       return $response->withJson(array('status' => 'User Created'),200);
       
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});