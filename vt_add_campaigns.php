<link rel='stylesheet' href='<?php echo VT_URL; ?>css/dashboard_styles.css' type='text/css' media='all' />
<link href="<?php echo VT_URL; ?>css/jquery.nouislider.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo VT_URL; ?>css/jquery.nouislider.min.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo VT_URL; ?>css/jquery-ui.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo VT_URL; ?>js/jquery.nouislider.all.min.js"></script>
<script type="text/javascript" src="<?php echo VT_URL; ?>js/jquery-ui.js"></script>
<div class="container">
    <div class="wrap">
        <?php echo vt_header(1); ?>
        <div class="clear"></div>
    </div>
</div>
<div class="dashboard_rsp"><div style="text-align: center;"><img class="vtldr" src="<?php echo VT_URL; ?>images/ajax-loader.gif"/></div></div>
<script>
    var app_url = "<?php echo VT_APP_URL; ?>";
    var api_url = app_url + "api/access/api.php";

    function shw_dashboard() {
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: api_url + '?rq=vt_3party_add_campaigns',
            data: 'api_key=<?php echo get_option('vt_api_key'); ?>&website=<?php echo home_url(); ?>&rqt=4',
            success: function (result) {
                if (result['status'] != "" && result['status'] == "Success") {
                    jQuery('.dashboard_rsp').html(result['html']);
                } else if(result['status'] != "" && result['status'] == "Failed" && result['msg'] == 'Api key does not exist.'){
                    document.location.href = '<?php echo home_url(); ?>/wp-admin/admin.php?page=VebtrafficSettings';
                } else if(result['status'] != "" && result['status'] == "Failed" && result['msg'] != "") {
                    jQuery('.dashboard_rsp').html('<br/><br/><div class="row-fluid"><div class="container">'+result['html']+'</div></div>');
                }
            }
        });
    }

    jQuery(document).ready(function () {
        shw_dashboard();
        jQuery(".rdshbrd").click(function(){
            jQuery('.dashboard_rsp').html('<div style="text-align: center;"><img class="vtldr" src="<?php echo VT_URL; ?>images/ajax-loader.gif"/></div>');
            shw_dashboard();
        });
    });
</script>