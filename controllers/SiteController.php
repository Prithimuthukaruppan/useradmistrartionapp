<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionUserform(){
        return $this->render('userform');
    }
    public function actionGridview(){
        return $this->render('gridview');
    }
    public function actionDeleteuser(){
        $data['flag']='E';
        if(!empty($_REQUEST['id'])){
            $modeleldet = \app\models\Usertable::findOne($_REQUEST['id']);
            if($modeleldet->delete()){
                $data['flag']='S';
            }
        }
        echo json_encode($data);
    }
    public function actionSaveform(){
        if(!empty($_REQUEST)){
            if(!empty($_REQUEST['userid'])){
                $modeledit = \app\models\Usertable::findOne($_REQUEST['userid']);
                $modeledit->name = $_REQUEST['Name'];
                $modeledit->username = $_REQUEST['Username'];
                $modeledit->email = $_REQUEST['email'];
                $modeledit->password = $_REQUEST['pwd'];
                $modeledit->mobileno = $_REQUEST['mobno'];
                $modeledit->imageupload = $_REQUEST['userdp'];
                $modeledit->dob = date('Y-m-d',strtotime($_REQUEST['dob']));
                $modeledit->status = $_REQUEST['status'];
                $modeledit->address = $_REQUEST['add'];
                $modeledit->country = $_REQUEST['cnt'];
                $modeledit->state = $_REQUEST['state'];
                $modeledit->city = $_REQUEST['city'];
                $modeledit->createdon = date('Y-m-d H:i:s');
                if($modeledit->save()){
                    $status = "s";
                }else{
                    $status = "e";
                }
            }else{
                $model = new \app\models\Usertable();
                $model->name = $_REQUEST['Name'];
                $model->username = $_REQUEST['Username'];
                $model->email = $_REQUEST['email'];
                $model->password = $_REQUEST['pwd'];
                $model->mobileno = $_REQUEST['mobno'];
                $model->imageupload = $_REQUEST['userdp'];
                $model->dob = $_REQUEST['dob'];
                $model->status = $_REQUEST['Status'];
                $model->address = $_REQUEST['add'];
                $model->country = $_REQUEST['cnt'];
                $model->state = $_REQUEST['state'];
                $model->city = $_REQUEST['city'];
                $model->createdon = date('Y-m-d H:i:s');
                if($model->save()){
                    $status['code'] = "s";
                    $status['userid'] = $model->usertbl_pk;
                }else{
                    $status['code'] = "e";
                }
            }
        }
        $enstatus = json_encode($status);
        return $enstatus;
    }
    public function actionViewdet(){
         if(!empty($_REQUEST['userid'])){
            $folder = 'web/uploads/';
            $model = \app\models\Usertable::findOne($_REQUEST['userid']);
            $data['name'] = $model->name;
            $data['upload'] = $model->imageupload;
            $data['link'] = $folder.$model->imageupload;
            $data['username'] = $model->username;
            $data['email'] = $model->email;
            $data['password'] = $model->password;
            $data['mobileno'] = $model->mobileno;
            $data['dob'] = $model->dob;
            $data['status'] = $model->status;
            $data['address'] = $model->address;
            $data['country'] = $model->country;
            $data['state'] = $model->state;
            $data['city'] = $model->city;
            $data['userid'] = $model->usertbl_pk;
            $jsndata = json_encode($data);
            return $jsndata;
         }
    }
    public function actionUpload(){
        $extension=['JPG', 'JPEG','jpg','jpeg'];        
       $file_name = $_FILES["file"]['name'];
       $file_ext1 = explode('.', $file_name);
       $file_ext = strtolower($file_ext1[1]);
       if(in_array($file_ext, $extension)){        
        $folder = 'web/uploads/';
       if (!is_dir($folder)) {
           mkdir($folder, 0777, true);
       }
       $allowedExtensions =$extension;
      
        if($_FILES["file"]['size']<=255106){
           $mime=mime_content_type($_FILES["file"]["tmp_name"]);
           $checkmime=$this->chkMime($file_ext, $mime);
           $folder=substr($folder, 0, strrpos( $folder, '/')).'/';   
           $filename = date('YmdHis') . rand() . '.'.$file_ext;
           $target_file = $folder .$filename;
           if(!$checkmime){
               move_uploaded_file($_FILES["file"]["tmp_name"],$target_file);
                $result['msg']='success';                               
           }else{   
           $result['msg']='error';
               $result['error']=  'Invalid File';
           }                     
       }else{
           $result['filename']='';
           $result['ext']='';
           $result['link']='';
           $result['msg']='error';
           $result['error']=  'File size should be less than 250KB';
           $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
       }
       $result['filename']=$filename;
       $result['link']= $folder .$filename;
       $result['ext']=$file_ext;
       $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
       }else{
           $result['filename']='';
           $result['ext']='';
           $result['link']='';
           $result['msg']='error';
           $result['error']=  'Invalid Image Format, Kindly upload a .JPG or .JPEG file.';
           $return =htmlspecialchars(json_encode($result), ENT_NOQUOTES);
       }
       echo $return;
    }
    function chkMime($ext,$mime){
       $ext=strtolower($ext);
       $mime_typ=array(
           'jpeg' => 'image/jpeg',
           'jpg' => 'image/jpeg');
           if($mime_typ[$ext]!=$mime){
               return true;
           }else{
               return false;
           }
   }
}
