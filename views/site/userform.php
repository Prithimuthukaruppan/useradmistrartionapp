<html>
    <head>
        <title>User Management</title>
    </head>
    <body>
       <form id="userform">
            <div class="container">
                <h1>User Management</h1>
                 <?php if(!isset($_REQUEST['view'])){ ?>
                <p>Please fill in the details to create an account with us.</p>
                 <?php } ?>
                <hr>                
                <label for="Name"><b>Name</b></label>
                <input type="text" class="formdet" placeholder="Enter Name" id="Name" name="Name"><br><br>
                <label for="uploaddoc" id="uploadlab"><b>Upload</b></label>
                <input type="hidden" class="formdet" id="attchmentuser" name="userdp" value="" class="pathinfo">
                <input type="file" class="custom-file-input fileupexcel" title="" id="uploaddoc" name="uploaddoc" ><br><br>
                <div class="profile_pic" style="display:none"></div><br><br>
                <label for="Username"><b>Username</b></label>
                <input type="text" class="formdet" placeholder="Enter Username"  id="Username" name="Username"><br><br>
                <label for="email"><b>Email ID</b></label>
                <input type="text" class="formdet" placeholder="Enter Email" id="email" name="email"><br><br>                
                <label for="pwd"><b>Password</b></label>
                <input type="password" class="formdet" placeholder="Enter Password" id="paswordtext" name="pwd"><br><br>
                <label for="confirm"><b>Confirm Password</b></label>
                <input type="password" class="formdet" placeholder="Confirm Password" id="confirmpass" name="confirm"><div class="registrationFormAlert" style="color:green;" id="CheckPasswordMatch"></div><br><br>
                <label for="mobno"><b>Mobile Number</b></label>
                <input type="text" class="formdet" placeholder="Enter Mobile number" id="mobno" name="mobno"><br><br>
                <label for="dob"><b>Date of Birth</b></label>
                <input type="date" class="formdet" placeholder="Enter Date of Birth" id="dob" name="dob"><br><br>
                <label for="add"><b>Address</b></label>
                <textarea type="text" placeholder="Enter Address" id="add" name="add"></textarea><br><br>
                <label for="cnt"><b>Country</b></label>
                <input type="text" class="formdet" placeholder="Enter Country" id="cnt" name="cnt"><br><br>
                <label for="state"><b>State</b></label>
                <input type="text" class="formdet" placeholder="Enter State" id="state" name="state"><br><br>
                <label for="city"><b>City</b></label>
                <input type="text" class="formdet" placeholder="Enter City" id="city" name="city"><br><br>
                <input type="hidden" class="formdet"  id="userid" name="userid"><br><br>
                <?php if(isset($_REQUEST['userid'])){ ?>
                <label for="Status"><b>Status</b></label>
                <select type="text" class="formdet" placeholder="Enter Status" id="Status" name="Status">
                    <option value="1">Active</option>
                    <option value="2">In-Active</option>
                </select><br><br>
                <?php } ?>
                <hr>
                <?php if(!isset($_REQUEST['view'])){ ?>
                <button id="usercretebtn" type="button" class="usercretebtncls"><strong>Submit</strong></button>
                <?php } ?>
            </div>
        </form> 
    </body>
</html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
 <script>
    function checkPasswordMatch() {
        var password = $("#paswordtext").val();
        var confirmPassword = $("#confirmpass").val();
        if (password != confirmPassword)
            $("#CheckPasswordMatch").html("Passwords does not match!");
        else
            $("#CheckPasswordMatch").html("Passwords match.");
    }
     function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
          return false;
        }else{
          return true;
        }
      }
    $(document).ready(function () {
        <?php if(isset($_REQUEST['userid'])){ 
                if(isset($_REQUEST['view'])){ ?>
                    $('.formdet').attr("disabled", "disabled"); 
                    $('#add').attr('readonly','readonly');
                    $('#uploaddoc').hide(); 
                <?php } ?>
                $.ajax({
                   url: '<?= yii\helpers\Url::toRoute(['site/viewdet','userid'=>$_REQUEST['userid']]) ?>',
                   dataType:'JSON',
                   success: function(data) {  
                       $('#Name').val(data.name);
                       $('#attchmentuser').val(data.upload);
                       $('.profile_pic').show();
                       $('.profile_pic').html("<img src='"+data.link+"' class='userpropic'>");
                       $('#Username').val(data.username);
                       $('#email').val(data.email);
                       $('#paswordtext').val(data.password);
                       $('#confirmpass').val(data.password);
                       $('#mobno').val(data.mobileno);
                       $('#dob').val(data.dob);
                       $('#add').val(data.address);
                       $('#cnt').val(data.country);
                       $('#state').val(data.state);
                       $('#city').val(data.city);
                       $('#userid').val(data.city);
                   }     
               });
        <?php } ?>
       $("#confirmpass").keyup(checkPasswordMatch);
       $('#usercretebtn').click(function(){
           if($('#Name').val()== ''){
               alert("Enter Name");
               return false;
           }
           else if($('#attchmentuser').val()== ''){
               alert("upload image");
               return false;
           }
           else if($('#Username').val()== ''){
               alert("Enter Username");
               return false;
           }
            else if($('#email').val()== ''){
               alert("Enter email");
               return false;
           }
           else if(IsEmail($('#email').val()==false)){
               alert("Invalid email");
               return false;
           }
           else if($('#paswordtext').val()== ''){
               alert("Enter Password");
               return false;
           }
           else if($('#confirmpass').val()== ''){
               alert("Enter Confirm Password");
               return false;
           }
           else if($('#mobno').val()== ''){
               alert("Enter Mobile number");
               return false;
           }
           else if($('#dob').val()== ''){
               alert("Enter Date of Birth");
               return false;
           }
           else if($('#add').val()== ''){
               alert("Enter Address");
               return false;
           }
           else if($('#cnt').val()== ''){
               alert("Enter Country");
               return false;
           }
           else if($('#state').val()== ''){
               alert("Enter state");
               return false;
           }
           else if($('#city').val()== ''){
               alert("Enter city");
               return false;
           }else{               
               $.ajax({
                   url: '<?= yii\helpers\Url::toRoute(['site/saveform']) ?>',
                   type: 'post',
                   dataType: 'JSON',
                   cache: false,
                   data: $('#userform').serialize(),
                    beforeSend:function(){$('#usercretebtn').css({"pointer-events":"none"});}, 
                   success: function(data) {  
                       if(data.code == 's'){
                          alert("submitted successfully");
                          window.location.href='<?= yii\helpers\Url::toRoute(['site/gridview']) ?>';
                       }else{
                           alert('Please try after some time!');
                       }
                   },
                  complete:function(){
                       $('#usercretebtn').css({"pointer-events":"auto"});
                  },

                 error:function(){
                       $('#usercretebtn').css({"pointer-events":"auto"});
                       alert('Please try after some time!');
                  }     
               });
           }
       });
$('.fileupexcel').on('change', function()
   {            
       var extfileName = $(this).prop('files')[0].name;
       var ext = extfileName.split('.').pop();
       if(ext.toLowerCase() == 'jpg' ||  ext.toLowerCase() == 'jpeg'){
           var sizefile = $(this).prop('files')[0].size;
           if(sizefile <= 250000){
               $('#attchmentuser').val('');
               var file_data = $(this).prop('files')[0];
               var form_data = new FormData();
               var type = $(this).prop('name');
               form_data.append('file', file_data)
               form_data.append('fname', type);
               $.ajax({
                   url: '<?= yii\helpers\Url::toRoute(['site/upload']) ?>',
                   dataType: 'JSON',
                   cache: false,
                   contentType: false,
                   processData: false,
                   data: form_data,
                   type:'post',   
                   success: function(data) {  
                       if (data.msg == 'success')
                       {
                          $('#attchmentuser').val(data.filename);                          
                          $('.profile_pic').show();
                          $('.profile_pic').html("<img src="+data.link+" class='userpropic'>");
                       }
                       else if (data.msg == "error")
                       {   
                           alert(data.error);
                       } else {
                           alert('Please try after some time!');
                       }
                   },
                  complete:function(){
                       $('#uploaddoc').val('');
                  },

                 error:function(){
                       $('#uploaddoc').val('');
                       alert('Please try after some time!');
                  }     
               });
           }else{
                   $('#uploaddoc').val('');
                   alert('File size should be less than 250KB');
                   return false;
           }           
       }else{
                   $('#uploaddoc').val('');
                   alert('Invalid Image Format, Kindly upload a .JPG or .JPEG file.');
                   return false;
       }
     });

    });
    
    </script>

