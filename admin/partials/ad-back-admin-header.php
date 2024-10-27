<div class="ab-top">
    <?php if (Integration_Checker::isFullIntegration()) { ?>
    <p class="logo">AdBack solution to Adblock</p>
    <?php } else { ?>
    <p class="logo">One Click Adblock Monetization</p>
    <?php } ?>
    <span class="slogan"><?PHP _e('by', 'adback-solution-to-adblock');?> <a
                href="https://www.adback.co">AdBack</a></span>
    <div class="ab-actions" style="padding-top: 10px;">
        <a target="_blank"
           href="https://twitter.com/intent/tweet?text=<?php echo urlencode("Re-establish dialogue and monetize your adblocked audience with this stunning WordPress plugin"); ?>&url=http://bit.ly/2oLYrHs&via=adback_co"
           class="ab-tweet"><span></span><?php _e( 'Tweet about it', 'ad-back' ); ?>
        </a>
        <a target="_blank" href="https://wordpress.org/support/plugin/adback-solution-to-adblock/reviews/"
           class="ab-review"><span></span><?php _e( 'Leave a review', 'ad-back' ); ?>
        </a>
    </div>
    <div class="clear"></div>
</div>
