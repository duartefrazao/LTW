<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../actions/action_verify_input.php');
    include_once('../actions/action_add_image.php');

    $message = array('type' => true, 'content' => 'Profile updated!');
    


    if(isset($_SESSION['username']))
    {
        $logoff = false;
        $info = getUserInfo($_SESSION['username']);

        $id = test_input($_POST['id']);
        
        $username = test_input($_POST['username']);

        $new_pass =  test_input($_POST['pass']);
        $re_new_pass = test_input($_POST['repass']);

        $error_found = false;

        if($info['username'] != $username)
        {   
            try{
            updateUsername($id,$username);
            $_SESSION['username'] = $username;
            }catch(PDOException $e){
                $message=array('type'=>'error_username',
                'content'=>'Username already taken, please choose another one!');
                $error_found = true;
            }

            //$logoff = true;
        }
        $description = test_input($_POST['description']);
        if($info['description'] != $description && !$error_found)
        {
            updateDescription($id,$description);
        }

        $mail = test_input($_POST['mail']);
        if($info['mail'] != $mail && !$error_found)
        {
            if(!verifyEmail($mail)){
                $message=array('type'=>'error_mail',
                'content'=>'Insert a valid mail');
                $error_found = true;
            }
            else
                updateMail($id,$mail);
            
        }

        

        if($new_pass !== $re_new_pass && !$error_found){
                $message=array('type'=>'error_password',
                'content'=>'Passwords do not match!');
                $error_found = true;
            }

        if(!$error_found && $new_pass != ''){  
            updatePassword($id,$new_pass);
            updateImageResource($id,'users',$description);
        }
    }

    echo json_encode($message);
?>