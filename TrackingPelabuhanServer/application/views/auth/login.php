<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title;?></title>
        <base href="<?php echo base_url(); ?>" />
        <link rel="shortcut icon" href="css/images/jangkar.png" />
        <link type="text/css" href="css/bootstrap.css" rel="stylesheet" />
        <link type="text/css" href="css/style.css" rel="stylesheet" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script>
            jQuery(document).ready(function(){
                if($('#txtuser').val() !== '') $('#txtpass').focus();
                else $('#txtuser').focus();
            });
        </script>
    </head>
    <body>
        <div id="wrapper">
            <div class="head"></div>
            <div class="foot"></div>
            <center>
                <img id="logo" src="css/images/logo_pelindo.png" />
            </center>
            <div id="page">
                <center>
                    <div id="panellogintop">
                        <label class="title">User Login</label>
                    </div>
                    <div id="panelloginbottom" class="panelloginbottom">
                        <div class="login-image"></div>
                        <!--<form name="formlogin" method="POST" action="login.php" >-->
                        <?php echo form_open("auth/login");?>
                            <table border="0">
                                <tr>
                                    <td>Username</td>
                                    <td>:</td>
                                    <td><input id="txtuser" name="username" type="text" value="<?php echo $user;?>"/></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td>:</td>
                                    <td><input id="txtpass" name="password" type="password" value=""/></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <input id="button-login" class="button-login" type="submit" value="Login" style="background-size: 100% 110px; width: 100%; height: 30px; margin-top: -5px;"/>
                                    </td>
                                </tr>
                            </table>
                        <!--</form>-->
                        <?php echo form_close();?>
                        <div style="clear: both;"></div>
                    </div>
                    <?php if($pesan!=null) {?>
                    <div id="pesanerror" ><?php echo ''.$pesan; ?></div>
                    <?php } ?>
                </center>
            </div>
        </div>
        <div id="footer" >
            <center>
                <hr/>
                <p>Pelabuhan tracking Server Copyright &copy; 2013. All Right Reserved.</p>
                Design by Yosua Willy Handika
            </center>
        </div>
    </body>
</html>
