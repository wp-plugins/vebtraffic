<link rel='stylesheet' href='<?php echo VT_URL; ?>css/dashboard_styles.css' type='text/css' media='all' />
<script src="<?php echo VT_URL; ?>js/plugin/flot/jquery.flot.cust.js"></script>
<script src="<?php echo VT_URL; ?>js/plugin/flot/jquery.flot.resize.js"></script>
<script src="<?php echo VT_URL; ?>js/plugin/flot/jquery.flot.fillbetween.min.js"></script>
<script src="<?php echo VT_URL; ?>js/plugin/flot/jquery.flot.orderBar.js"></script>
<script src="<?php echo VT_URL; ?>js/plugin/flot/jquery.flot.pie.js"></script>
<script src="<?php echo VT_URL; ?>js/plugin/flot/jquery.flot.tooltip.js"></script>
<div class="container">
    <div class="wrap">
        <?php echo vt_header(1); ?>
        <div class="clear"></div>
        <div class="socl">
        <div class="left"><h2>Share your surfer URL and get traffic.</h2>
        <form action="" method="post">
        <input name="" id="" class="srflinkfield" type="text" value="<?php if(get_option('vt_surfer_link') && get_option('vt_surfer_link') != "undefined"){ echo VT_APP_URL . 'share_traffic/' . get_option('vt_surfer_link'); }; ?>" />
        </form>
        </div>
        <div class="right"><h2>Social Share</h2>
        <ul>
        <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo VT_APP_URL . 'share_traffic/' . get_option('vt_surfer_link'); ?>" class="fb">fb</a></li>
        <li><a target="_blank" href="https://twitter.com/home?status=<?php echo VT_APP_URL . 'share_traffic/' . get_option('vt_surfer_link'); ?>" class="tw">tw</a></li>
        <li><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo VT_APP_URL . 'share_traffic/' . get_option('vt_surfer_link'); ?>&title=Traffic%20Viewer&summary=&source=" class="in">in</a></li>
        <li><a target="_blank" href="https://plus.google.com/share?url=<?php echo VT_APP_URL . 'share_traffic/' . get_option('vt_surfer_link'); ?>" class="gp">gp</a></li>
        <li><a target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo get_option('vt_surfer_link'); ?>&media=&description=" class="pin">pin</a></li>
        <div class="clear"></div>
        </ul>
        </div>
        <div class="clear"></div>
        </div>
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
            url: api_url + '?rq=register_3party_dashboard',
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
        jQuery(".srflinkfield").click(function(){
		this.select();
	});
    });
</script>