<?php

function vt_header($show = 0, $wide = 0) {
    $html = '';
    $html .= '<h2 class="logo"><img src="' . VT_URL . 'images/logo.png"></h2>';
    if ($show == 1) {
        $html .= '<a href="javascript:void(0);" class="button button-primary button-large submit1 rdshbrd" style="margin-top: 24px !important;">Refresh</a>';
    }
    if ($wide == 1) {
        if (get_option('vt_surfer_link') && get_option('vt_surfer_link') != "undefined") {
            $html .= '<a target="_blank" style="margin-right:18px;margin-top: 24px !important;" class="button button-primary button-large submit1 rdshbrd rdshbrd2" href="' . VT_APP_URL . 'share_traffic/' . get_option('vt_surfer_link') . '">Surfer Link</a>';
        }
        $html .= '<a target="_blank" style="margin-right:5px;margin-top: 24px !important;" class="button button-primary button-large submit1 rdshbrd rdshbrd2" href="' . VT_APP_URL . 'app/?api_key=' . get_option('vt_api_key') . '&rd_url=' . VT_APP_URL . 'app/upgrade.php">Upgrade</a>';
    } else {
        if (get_option('vt_surfer_link') && get_option('vt_surfer_link') != "undefined") {
            $html .= '<a target="_blank" style="margin-right:5px;margin-top: 24px !important;" class="button button-primary button-large submit1 rdshbrd" href="' . VT_APP_URL . 'share_traffic/' . get_option('vt_surfer_link') . '">Surfer Link</a>';
        }
        $html .= '<a target="_blank" style="margin-right:5px;margin-top: 24px !important;" class="button button-primary button-large submit1 rdshbrd" href="' . VT_APP_URL . 'app/?api_key=' . get_option('vt_api_key') . '&rd_url=' . VT_APP_URL . 'app/upgrade.php">Upgrade</a>';
    }
    return $html;
}

?>