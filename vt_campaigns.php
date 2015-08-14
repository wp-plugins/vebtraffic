<link rel='stylesheet' href='<?php echo VT_URL; ?>css/dashboard_styles.css' type='text/css' media='all' />
<link href="<?php echo VT_URL; ?>bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" />
<link href="<?php echo VT_URL; ?>bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" />
<script src="<?php echo VT_URL; ?>bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="<?php echo VT_URL; ?>bootstrap-modal/js/bootstrap-modal.js"></script>
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
            url: api_url + '?rq=vt_3party_campaigns',
            data: 'api_key=<?php echo get_option('vt_api_key'); ?>&website=<?php echo home_url(); ?>&rqt=4',
            success: function (result) {
                if (result['status'] != "" && result['status'] == "Success") {
                    jQuery('.dashboard_rsp').html(result['html']);
                } else if (result['status'] != "" && result['status'] == "Failed" && result['msg'] == 'Api key does not exist.') {
                    document.location.href = '<?php echo home_url(); ?>/wp-admin/admin.php?page=VebtrafficSettings';
                } else if (result['status'] != "" && result['status'] == "Failed" && result['msg'] != "") {
                    jQuery('.dashboard_rsp').html('<br/><br/><div class="row-fluid"><div class="container">' + result['html'] + '</div></div>');
                }
            }
        });
    }

    function shw_campaigns(param) {
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: api_url + param,
            data: 'api_key=<?php echo get_option('vt_api_key'); ?>&website=<?php echo home_url(); ?>&rqt=4',
            success: function (result) {
                if (result['status'] != "" && result['status'] == "Success") {
                    jQuery('.dashboard_rsp').html(result['html']);
                } else if (result['status'] != "" && result['status'] == "Failed" && result['msg'] == 'Api key does not exist.') {
                    document.location.href = '<?php echo home_url(); ?>/wp-admin/admin.php?page=VebtrafficSettings';
                } else if (result['status'] != "" && result['status'] == "Failed" && result['msg'] != "") {
                    jQuery('.dashboard_rsp').html('<br/><br/><div class="row-fluid"><div class="container">' + result['html'] + '</div></div>');
                }
            }
        });
    }

    jQuery(document).ready(function () {
        shw_dashboard();
        jQuery(".rdshbrd").click(function () {
            jQuery('.dashboard_rsp').html('<div style="text-align: center;"><img class="vtldr" src="<?php echo VT_URL; ?>images/ajax-loader.gif"/></div>');
            shw_dashboard();
        });
        jQuery("body").on('click', '.pagination li a', function () {
            var href = jQuery(this).attr('href');
            if (href != "javascript:void(0);") {
                jQuery('.dashboard_rsp').html('<div style="text-align: center;"><img class="vtldr" src="<?php echo VT_URL; ?>images/ajax-loader.gif"/></div>');
                shw_campaigns(href);
            }
            return false;
        });

        jQuery('body').on('click', '.act_cpd', function () {
            var _this = jQuery(this);
            if (_this.attr('data-act') != "") {
                var ctext = "";
                var clink = "";
                if (_this.attr('data-act') == 'cln') {
                    ctext = "Are you sure you want to clone this campaign.";
                    clink = "do=" + _this.attr('data-act') + "&i=" + _this.attr('rel') + "";
                } else if (_this.attr('data-act') == 'ply') {
                    ctext = "Are you sure you want to resume this campaign.";
                    clink = "do=" + _this.attr('data-act') + "&i=" + _this.attr('rel') + "";
                } else if (_this.attr('data-act') == 'paus') {
                    ctext = "Are you sure you want to pause this campaign.";
                    clink = "do=" + _this.attr('data-act') + "&i=" + _this.attr('rel') + "";
                } else if (_this.attr('data-act') == 'del') {
                    ctext = "Are you sure you want to delete this campaign.";
                    clink = "do=" + _this.attr('data-act') + "&i=" + _this.attr('rel') + "";
                }
                var tmpl = [
                    '<div class="modal hide fade" tabindex="-1">',
                    '<div class="modal-header">',
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>',
                    '<h4 class="modal-title">Are You Sure?</h4>',
                    '</div>',
                    '<div class="modal-body">',
                    '<p>' + ctext + '</p>',
                    '</div>',
                    '<div class="modal-footer">',
                    '<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-no">No</a>',
                    '<a href="' + clink + '&api_key=<?php echo get_option('vt_api_key'); ?>&rqt=4" class="btn btn-yes">Yes</a>',
                    '</div>',
                    '</div>'
                ].join('');
                jQuery(tmpl).modal();
            }
        });

        jQuery('body').on('hidden.bs.modal', function (e) {
            jQuery('.p2p_act').val('');
        });

        jQuery('body').on('click', '.btn-yes', function () {
            var _this = jQuery(this);
            jQuery.ajax({
                type: "POST",
                url: api_url+'?rq=vt_3party_campaigns_action',
                data: _this.attr('href'),
                dataType: "json",
                success: function (result) {
                    if (result['pass'] == 1) {
                        location.reload(true);
                        jQuery('.modal').modal('hide');
                    } else {
                        jQuery('.modal').modal('hide');
                        jQuery('.rsp').addClass('rsp_error').hide().fadeIn().html(result['error']).delay(3000).fadeOut();
                    }
                }
            });
            return false;
        });
    });
</script>