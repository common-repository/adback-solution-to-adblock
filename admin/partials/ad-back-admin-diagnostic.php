<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/admin/partials
 */
?>
<?php include "ad-back-admin-header.php" ?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1><?php _e('AdBack : The stats of your AdBlock audience', 'adback-solution-to-adblock'); ?></h1>

<hr class="clear">

<div class="row">
    <button class="ab-button ab-button-primary copy-png-btn" id="copy-diagnostic">Copy diagnostic</button>
</div>

<?php
$ok = "<svg class=\"ok-svg\" xmlns:cc=\"http://creativecommons.org/ns#\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns:svg=\"http://www.w3.org/2000/svg\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:sodipodi=\"http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd\" xmlns:inkscape=\"http://www.inkscape.org/namespaces/inkscape\" viewBox=\"0 -256 1792 1792\" id=\"svg3013\" version=\"1.1\" inkscape:version=\"0.48.3.1 r9886\" width=\"20%\" height=\"20%\" sodipodi:docname=\"ok_sign_font_awesome.svg\"><metadata id=\"metadata3023\"><rdf:RDF><cc:Work rdf:about=\"\"><dc:format>image/svg+xml</dc:format><dc:type rdf:resource=\"http://purl.org/dc/dcmitype/StillImage\"/></cc:Work></rdf:RDF></metadata><defs id=\"defs3021\"/><sodipodi:namedview pagecolor=\"#ffffff\" bordercolor=\"#666666\" borderopacity=\"1\"objecttolerance=\"10\" gridtolerance=\"10\" guidetolerance=\"10\"inkscape:pageopacity=\"0\" inkscape:pageshadow=\"2\" inkscape:window-width=\"640\"inkscape:window-height=\"480\" id=\"namedview3019\" showgrid=\"false\"inkscape:zoom=\"0.13169643\" inkscape:cx=\"896\" inkscape:cy=\"896\"inkscape:window-x=\"0\" inkscape:window-y=\"25\" inkscape:window-maximized=\"0\"inkscape:current-layer=\"svg3013\"/><g transform=\"matrix(1,0,0,-1,113.89831,1270.2373)\" id=\"g3015\"><path d=\"m 1284,802 q 0,28 -18,46 l -91,90 q -19,19 -45,19 -26,0 -45,-19 L 677,531 451,757 q -19,19 -45,19 -26,0 -45,-19 l -91,-90 q -18,-18 -18,-46 0,-27 18,-45 L 632,214 q 19,-19 45,-19 27,0 46,19 l 543,543 q 18,18 18,45 z M 1536,640 Q 1536,431 1433,254.5 1330,78 1153.5,-25 977,-128 768,-128 559,-128 382.5,-25 206,78 103,254.5 0,431 0,640 0,849 103,1025.5 206,1202 382.5,1305 559,1408 768,1408 977,1408 1153.5,1305 1330,1202 1433,1025.5 1536,849 1536,640 z\"id=\"path3017\" inkscape:connector-curvature=\"0\" style=\"fill:green\"/></g></svg>";
$ko = "<svg class=\"ko-svg\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:cc=\"http://creativecommons.org/ns#\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns:svg=\"http://www.w3.org/2000/svg\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:sodipodi=\"http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd\" xmlns:inkscape=\"http://www.inkscape.org/namespaces/inkscape\" viewBox=\"0 -256 1792 1792\" id=\"svg3013\" version=\"1.1\" inkscape:version=\"0.48.3.1 r9886\" width=\"20%\" height=\"20%\" sodipodi:docname=\"remove_sign_font_awesome.svg\">metadata id=\"metadata3023\"><rdf:RDF><cc:Work rdf:about=\"\"><dc:format>image/svg+xml</dc:format><dc:type rdf:resource=\"http://purl.org/dc/dcmitype/StillImage\"/></cc:Work></rdf:RDF></metadata><defs id=\"defs3021\"/><sodipodi:namedview pagecolor=\"#ffffff\" bordercolor=\"#666666\" borderopacity=\"1\" objecttolerance=\"10\" gridtolerance=\"10\" guidetolerance=\"10\" inkscape:pageopacity=\"0\" inkscape:pageshadow=\"2\" inkscape:window-width=\"640\" inkscape:window-height=\"480\" id=\"namedview3019\" showgrid=\"false\" inkscape:zoom=\"0.13169643\" inkscape:cx=\"896\" inkscape:cy=\"896\" inkscape:window-x=\"0\" inkscape:window-y=\"25\" inkscape:window-maximized=\"0\" inkscape:current-layer=\"svg3013\"/><g transform=\"matrix(1,0,0,-1,136.67797,1293.0169)\" id=\"g3015\"><path d=\"m 1149,414 q 0,26 -19,45 l -181,181 181,181 q 19,19 19,45 0,27 -19,46 l -90,90 q -19,19 -46,19 -26,0 -45,-19 L 768,821 587,1002 q -19,19 -45,19 -27,0 -46,-19 l -90,-90 q -19,-19 -19,-46 0,-26 19,-45 L 587,640 406,459 q -19,-19 -19,-45 0,-27 19,-46 l 90,-90 q 19,-19 46,-19 26,0 45,19 L 768,459 949,278 q 19,-19 45,-19 27,0 46,19 l 90,90 q 19,19 19,46 z m 387,226 Q 1536,431 1433,254.5 1330,78 1153.5,-25 977,-128 768,-128 559,-128 382.5,-25 206,78 103,254.5 0,431 0,640 0,849 103,1025.5 206,1202 382.5,1305 559,1408 768,1408 977,1408 1153.5,1305 1330,1202 1433,1025.5 1536,849 1536,640 z\" id=\"path3017\" inkscape:connector-curvature=\"0\" style=\"fill:#AB0F15\"/></g></svg>";
?>
<div id="table-diagnostic" class="row">
    <div class="ab-col-md-9">
        <table class="ad-back-diagnostic clear" style="overflow-x:auto;">
            <tr>
                <td>
                    Analytics domain
                </td>
                <td>
                    <?php echo $script['analytics_domain'] ? $script['analytics_domain'] : null; ?>
                </td>
                <td><?php echo $script['analytics_domain'] ? $ok : $ko; ?></td>
            </tr>
            <tr>
                <td>
                    Analytics script name
                </td>
                <td>
                    <?php echo $script['analytics_script'] ? $script['analytics_script'] : null; ?>
                </td>
                <td><?php echo $script['analytics_script'] ? $ok : $ko; ?></td>
            </tr>
            <tr>
                <td>
                    Message domain
                </td>
                <td>
                    <?php echo $script['message_domain'] ? $script['message_domain'] : null; ?>
                </td>
                <td><?php echo $script['message_domain'] ? $ok : $ko; ?></td>
            </tr>
            <tr>
                <td>
                    Message script name
                </td>
                <td>
                    <?php echo $script['message_script'] ? $script['message_script'] : null; ?>
                </td>
                <td><?php echo $script['message_script'] ? $ok : $ko; ?></td>
            </tr>
            <tr>
                <td>
                    Token
                </td>
                <td>
                    <?php echo $token->access_token ? $token->access_token : null; ?>
                </td>
                <td><?php echo $token->access_token ? $ok : $ko; ?></td>
            </tr>
            <tr>
                <td>
                    Script working
                </td>
                <td>
                    adback.API().start
                </td>
                <td class="working-script"><?php echo $ko; ?></td>
            </tr>
            <tr>
                <td>Endpoint / Old endpoint / Next endpoint</td>
                <td>
                    <?php echo $endPoints->end_point ? $endPoints->end_point : 'x'; ?>
                    <?php echo $endPoints->old_end_point ? $endPoints->old_end_point : 'x'; ?>
                    <?php echo $endPoints->next_end_point ? $endPoints->next_end_point : 'x'; ?>
                </td>
                <td><?php echo (null !== $endPoints) ? $ok : $ko; ?></td>
            </tr>
        </table>

        <h2>Rewrite rules
            <button onclick="jQuery('.ad-back-diagnostic-rules').toggle()">Show / Hide</button>
        </h2>
        <table class="ad-back-diagnostic-rules clear" style="overflow-x:auto; display: none">
            <tr>
                <th>Rule</th>
                <th>Rewrite</th>
                <th>AdBack?</th>
            </tr>
            <?php if (is_array($rules)) : ?>
                <?php foreach ($rules as $rule => $rewrite) : ?>
                    <tr>
                        <td><?php echo $rule; ?></td>
                        <td><?php echo $rewrite; ?></td>
                        <td class="ad-back-rule-adback">
                            <?php echo preg_match('/^('
                                . ($endPoints->old_end_point ? $endPoints->old_end_point : '')
                                . '|'
                                . ($endPoints->end_point ? $endPoints->end_point : '')
                                . '|' . ($endPoints->next_end_point ? $endPoints->next_end_point : '')
                                . ')\/.*/', $rule) ? $ok : '';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</div>
<script type="text/javascript">
    (function ($) {
        $(window).on("load", function () {
            if ('function' === typeof window[document.getElementById('adback_data').getAttribute('data-adback')].API().start) {
                $(".working-script").replaceWith('<?php echo "<td>" . $ok . "</td>"; ?>')
            }
        });
        $("#copy-diagnostic").on('click', function () {
            $("body").find("svg.ok-svg").replaceWith("<p class=\"ok-svg\">OK</p>");
            $("body").find("svg.ko-svg").replaceWith("<p class=\"ko-svg\">ERROR</p>");

            html2canvas($("#table-diagnostic")[0]).then(function (canvas) {
                Canvas2Image.saveAsPNG(canvas);
                $("body").find("p.ok-svg").replaceWith('<?php echo $ok ?>');
                $("body").find("p.ko-svg").replaceWith('<?php echo $ko ?>');
            });
        });
    })(jQuery);
</script>
