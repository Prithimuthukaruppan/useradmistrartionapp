<?php

use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
?>
<html>
    <head>
        <title>User Management</title>
    </head>
    <body>
       <form id="userform">
            <div class="container">
                <h1>User Management - Grid view</h1>
                <hr>                
                <label for="Username"><b>Username</b></label>
                <input type="text" class="formdet" placeholder="Enter Username" id="Username" name="Username"><br><br>
                <hr>
                <button id="usersearchbtn" type="button" class="usersearchbtncls"><strong>Submit</strong></button>
                <button id="resetbtn" type="button" class="resetbtncls"><strong>Reset</strong></button>
            </div><br><br>
        </form> 
        <div>
            <?php 
            $dataprovider = app\models\Usertable::getlistdata();
            Pjax::begin(['id' => 'user_list', 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);

            echo \yii\grid\GridView::widget([
                'dataProvider' => $dataprovider,                                                      
                'layout' => '{summary}{items}<div class="dataTables_paginate paging_simple_numbers">{pager} </div>',

                'pager' => [

                 'nextPageLabel' => '>',
                    'prevPageLabel' => '<',
                    'options' => [
                        'tag' => 'div',
                        'class' => '',
                        'id' => '',
                    ],
                ],
                'id' => 'user_list_grid',
                'columns' => [
                    [
                        'label' => 'Name',
                        'content' => function($data){
                           return $data->name;
                        }
                    ],
                    [
                        'label' => 'Username',
                        'content' => function($data){
                           return $data->username;
                        }
                    ],
                    [
                        'label' => 'Email ID',
                        'content' => function($data){
                           return $data->email;
                        }
                    ],
                    [
                        'label' => 'Mobile Number',
                        'content' => function($data){
                           return $data->mobileno;
                        }
                    ],
                    [
                        'label' => 'status',
                        'content' => function($data){
                             if($data->status == 1){
                               return 'Active';
                            }else{
                                return 'In - Active';
                            }
                        }
                    ],

                         ['class' => 'yii\grid\ActionColumn', 
                             'header' => 'Action', 
                        'template' => '{update}{delete}{view}',
                        'visible' => true,
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return  '<a class="font-14 m-r-5 memberedit" href="'.$url.'" title="Edit">Edit</a>&nbsp&nbsp';                                                              

                            },
                            'delete' => function ($url, $model) {
                                return  '<a class="font-14 m-r-5 recdelete" title="Delete" data-id="'.$model->usertbl_pk.'">Delete</a>&nbsp&nbsp';
                                
                            },
                            'view'=>function ($url, $model) {
                                return  '<a class="font-14 m-r-5 recview" href="'.$url.'" title="View">View</a>&nbsp&nbsp';
                                
                            }
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'update') {
                                $url = yii\helpers\Url::toRoute(['site/userform','userid'=>$model->usertbl_pk]);
                                return $url;
                            }

                             if ($action === 'view') {
                                $url = yii\helpers\Url::toRoute(['site/userform','userid'=>$model->usertbl_pk,'view'=>1]);
                                return $url;
                            }
                        }
                    ],
                ],
            ]);
            \yii\widgets\Pjax::end();
            ?>
        </div>
    </body>
</html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).on('click', '#usersearchbtn', function () {
        $.pjax.reload({data: 'Username=' + $('#Username').val(), type: 'POST', container: '#user_list'});
    });
    $(document).on('click', '.recdelete', function () {
        var id = $(this).attr('data-id');
        var self = $(this);
        $.ajax({
            url: '<?= yii\helpers\Url::toRoute(['site/deleteuser']) ?>',
            data: 'id=' + id,
            type: 'post',
            dataType: 'json',
            beforeSend:function(){self.css({'pointer-events':'none'})},
            success: function (data) {
                if (data.flag == 'S') {
                    alert('Successfully Deleted');
                    $.pjax.reload({type: 'POST', container: '#user_list'});
                }
                self.css({'pointer-events':'auto'});
            },
            error:function(){
                self.css({'pointer-events':'auto'});
                alert('Please try after some time!');
            },
        });
    });
    $(document).on('click', '#resetbtn', function () {
        $('#Username').val('');
        $.pjax.reload({type: 'POST', container: '#user_list'});
    });
    </script>