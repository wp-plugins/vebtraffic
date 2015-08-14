<?php echo vt_header(0,1); ?>
<br/>
<div class="clear"></div>
<div class="wrap sgbg">
    <h2 class="sgbgh2">Sign Up</h2>
    <div class="rsp">
        <br/>
        <div class="notice below-h2" id="message"><p></p></div>
        <br/>
    </div>
    <div class="rsp2">
        <br/>
        <div class="notice below-h2" id="message"><p></p></div>
        <br/>
    </div>
    <div class="rsp3">
        <br/>
        <div class="notice below-h2" id="message"><p></p></div>
        <br/>
    </div>
    <div class="signupform sgbg1">
        <form role="form" action="" method="post" id="register" class="registration-form" autocomplete="off">
            <label>First Name</label><br/>
            <input type="text" id="fname" name="f_name"><br/><br/>
            <label>Last Name</label><br/>
            <input type="text" id="lname" name="l_name"><br/><br/>
            <label>Email</label><br/>
            <input type="text" id="email" name="email_address"><br/><br/>
            <label>Website</label><br/>
            <div class="field_div"><?php echo home_url(); ?></div><br/>
            <input type="submit" class="button button-primary button-large submit1" value="Signup" id="" name="">
            <p class="ihl">Already have an account? <a href="javascript:void(0);" class="signin">Sign In</a></p>
            <div class="clear"></div>
        </form>
    </div>
    <div class="loginform sgbg3" style="display: none;">
        <form role="form" action="" method="post" id="loginfrm">
            <label>Email</label><br/>
            <input type="text" id="lg_email" name="email_address"><br/><br/>
            <label>Password</label><br/>
            <input type="password" id="password" name="vt_pass"><br/><br/>
            <input type="submit" class="button button-primary button-large submit1" value="Login" id="" name="">
            <p class="ihl2">Don't have an account? <a href="javascript:void(0);" class="signup">Sign Up</a></p>
            <div class="clear"></div>
        </form>
    </div>
    <div class="sgbg2">
        <h3>OR</h3>
        <h2>Enter Api key</h2>
        <form role="form" action="" method="post" id="enterapikeyfrm" class="enterapikey-form" autocomplete="off">
            <input type="text" id="enterapikey" name="api_key" value="<?php echo get_option('vt_api_key'); ?>"><br/><br/>
            <input type="submit" class="button button-primary button-large submit2" value="Submit" id="" name="">
            <div class="clear"></div>
        </form>
    </div>
    <div style="clear:both"></div>
</div>
<script>
    var app_url = "<?php echo VT_APP_URL; ?>";
    var api_url = app_url + "api/access/api.php";

    jQuery(document).ready(function () {
        jQuery('body').on('click', '.signin', function () {
            jQuery('.sgbgh2').html('Sign In');
            jQuery('.rsp').hide();
            jQuery('.signupform').hide();
            jQuery('.loginform').show();
            return false;
        });
        jQuery('.signup').click(function () {
            jQuery('.sgbgh2').html('Sign Up');
            jQuery('.loginform').hide();
            jQuery('.signupform').show();
            return false;
        });

        jQuery('#register').submit(function () {
            var fname = jQuery('#fname');
            var lname = jQuery('#lname');
            var email = jQuery('#email');
            if (fname.val() == "") {
                fname.css('border', '1px solid #ed7a53');
                fname.focus();
                return false;
            } else {
                fname.css('border', '1px solid #008aff');
            }
            if (lname.val() == "") {
                lname.css('border', '1px solid #ed7a53');
                lname.focus();
                return false;
            } else {
                lname.css('border', '1px solid #008aff');
            }
            if (email.val() == "") {
                email.css('border', '1px solid #ed7a53');
                email.focus();
                return false;
            } else {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                var emailaddressVal = email.val();
                if (!emailReg.test(emailaddressVal)) {
                    email.focus();
                    email.css('border', '1px solid #ed7a53');
                    return false;
                } else {
                    email.css('border', '1px solid #008aff');
                }
            }

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: api_url + '?rq=register_3party',
                data: jQuery(this).serialize() + '&website=<?php echo home_url(); ?>&rqt=4',
                success: function (result) {
                    if (result['status'] != "" && result['status'] == "Success") {
                        jQuery('.rsp').hide();
                        jQuery('.rsp2').hide();
                        jQuery('.rsp3').hide();
                        jQuery('.rsp').show(function () {
                            jQuery(this).children('.notice').removeClass('notice-error').addClass('notice-success').children('p').html(result['msg']);
                        }).delay(3000).fadeOut(1000);
                        if (result['api_key'] != '') {
                            jQuery.ajax({
                                type: "POST",
                                dataType: 'json',
                                url: ajaxurl,
                                data: 'api_key=' + result['api_key'] + '&surfer_link=' + result['surfer_link'] + '&do=update_api_key&action=update_vt_options&vt_nonce=' + vt_vars.vt_nonce,
                                success: function (result2) {
                                    jQuery('#enterapikey').val(result['api_key']);
                                    jQuery('.rsp').hide();
                                    jQuery('.rsp2').hide();
                                    jQuery('.rsp3').hide();
                                    jQuery('.rsp3').show(function () {
                                        jQuery(this).children('.notice').removeClass('notice-error').addClass('notice-success').children('p').html(result2['msg']);
                                    }).delay(3000).fadeOut(1000, function () {
                                        document.location.href = '<?php echo home_url(); ?>/wp-admin/admin.php?page=VebtrafficHome';
                                    });
                                }
                            });
                        }
                    } else if (result['status'] != "" && result['status'] == "Failed") {
                        jQuery('.rsp').hide();
                        jQuery('.rsp2').hide();
                        jQuery('.rsp3').hide();
                        jQuery('.rsp').show(function () {
                            jQuery(this).children('.notice').removeClass('notice-success').addClass('notice-error').children('p').html(result['msg']);
                        });
                        email.css('border', '1px solid #ed7a53');
                        email.focus();
                    }
                }
            });
            return false;
        });

        jQuery('#loginfrm').submit(function () {
            var email = jQuery('#lg_email');
            var password = jQuery('#password');
            if (email.val() == "") {
                email.css('border', '1px solid #ed7a53');
                email.focus();
                return false;
            } else {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                var emailaddressVal = email.val();
                if (!emailReg.test(emailaddressVal)) {
                    email.focus();
                    email.css('border', '1px solid #ed7a53');
                    return false;
                } else {
                    email.css('border', '1px solid #008aff');
                }
            }
            if (password.val() == "") {
                password.css('border', '1px solid #ed7a53');
                password.focus();
                return false;
            } else {
                password.css('border', '1px solid #008aff');
            }
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: api_url + '?rq=register_3party_api_login',
                data: jQuery(this).serialize() + '&website=<?php echo home_url(); ?>&rqt=4',
                success: function (result) {
                    if (result['status'] != "" && result['status'] == "Success") {
                        if (result['api_key'] != '') {
                            jQuery.ajax({
                                type: "POST",
                                dataType: 'json',
                                url: ajaxurl,
                                data: 'api_key=' + result['api_key'] + '&surfer_link=' + result['surfer_link'] + '&do=update_api_key&action=update_vt_options&vt_nonce=' + vt_vars.vt_nonce,
                                success: function (result2) {
                                    jQuery('#enterapikey').val(result['api_key']);
                                    jQuery('.rsp').hide();
                                    jQuery('.rsp2').hide();
                                    jQuery('.rsp3').hide();
                                    jQuery('.rsp3').show(function () {
                                        jQuery(this).children('.notice').removeClass('notice-error').addClass('notice-success').children('p').html(result2['msg']);
                                    }).delay(3000).fadeOut(1000, function () {
                                        document.location.href = '<?php echo home_url(); ?>/wp-admin/admin.php?page=VebtrafficHome';
                                    });
                                }
                            });
                        }
                    } else if (result['status'] != "" && result['status'] == "Failed") {
                        jQuery('.rsp').hide();
                        jQuery('.rsp2').hide();
                        jQuery('.rsp3').hide();
                        jQuery('.rsp2').show(function () {
                            jQuery(this).children('.notice').removeClass('notice-success').addClass('notice-error').children('p').html(result['msg']);
                        });
                        email.css('border', '1px solid #ed7a53');
                        email.focus();
                    }
                }
            });
            return false;
        });

        jQuery('#enterapikeyfrm').submit(function () {
            var enterapikey = jQuery('#enterapikey');
            if (enterapikey.val() == "") {
                enterapikey.css('border', '1px solid #ed7a53');
                enterapikey.focus();
                return false;
            } else {
                enterapikey.css('border', '1px solid #008aff');
            }
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: api_url + '?rq=register_3party_api_key_check',
                data: jQuery(this).serialize() + '&website=<?php echo home_url(); ?>&rqt=4',
                success: function (result) {
                    if (result['status'] != "" && result['status'] == "Success") {
                        if (result['api_key'] != '') {
                            jQuery.ajax({
                                type: "POST",
                                dataType: 'json',
                                url: ajaxurl,
                                data: 'api_key=' + result['api_key'] + '&surfer_link=' + result['surfer_link'] + '&do=update_api_key&action=update_vt_options&vt_nonce=' + vt_vars.vt_nonce,
                                success: function (result2) {
                                    jQuery('#enterapikey').val(result['api_key']);
                                    jQuery('.rsp').hide();
                                    jQuery('.rsp2').hide();
                                    jQuery('.rsp3').hide();
                                    jQuery('.rsp3').show(function () {
                                        jQuery(this).children('.notice').removeClass('notice-error').addClass('notice-success').children('p').html(result2['msg']);
                                    }).delay(3000).fadeOut(1000, function () {
                                        document.location.href = '<?php echo home_url(); ?>/wp-admin/admin.php?page=VebtrafficHome';
                                    });
                                }
                            });
                        }
                    } else if (result['status'] != "" && result['status'] == "Failed") {
                        jQuery('.rsp').hide();
                        jQuery('.rsp2').hide();
                        jQuery('.rsp3').hide();
                        jQuery('.rsp3').show(function () {
                            jQuery(this).children('.notice').removeClass('notice-success').addClass('notice-error').children('p').html(result['msg']);
                        });
                    }
                }
            });
            return false;
        });
    });
</script>