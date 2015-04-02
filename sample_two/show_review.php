<div class="ui-bar-c ui-corner-all" id="content"
     style="min-width: 300px; padding:0px; font-weight:normal; text-align:center;">
    <div class="form-head  message-summary" style="margin:6px;"><?php echo $this->lang->line('review_reviews_for'); ?>
        <span class="send-to-name"></span></div>
    <input type="hidden" name="review-reciever-id" id="review-reciever-id" value="<?php echo $receiver_id; ?>"/>

    <div style="margin:3px">

    </div>
    <div class="ui-bar-c ui-corner-all ui-overlay-shadow" style="text-align:left; margin:2px;font-weight:normal; ">
        <img class="ui-corner-all" style="float:left; padding:2px;" height="70" width="70"
             src="<?php echo $this->config->item(
                     'image-profile'
                 ) . $userDtlArr[$receiver_id]['upro_image_name'] . '?t=' . time(); ?>">

        <div style="min-height:75px;">
            <span><strong><?php echo $userDtlArr[$receiver_id]['upro_name']; ?></strong></span>
            <br/>
            <span id="rate_user_container_pop" class="rating_container"></span>
            <!--<span style="padding: 4px;">
        <?php for ($i = 0; $i < 5; $i++):
            if($userDtlArr[$receiver_id]['upro_rating']>$i): ?>
                <img width="15" height="15" class="seat-avail" src="<?php echo $this->config->item('mobile-image'); ?>full_star.png">
                <?php     else: ?>
                <img width="15" height="15" class="seat-avail" src="<?php echo $this->config->item('mobile-image'); ?>empty_star.png">
            <?php     endif;  ?>
        <?php  endfor; ?>
        </span>--><br/>
            <!--<button class="ui-bar-c ui-corner-all" style="padding:3px;" type="submit" data-theme="b"onClick="newReview('<?php echo $receiver_id; ?>');return false;"><?php echo $this->lang->line('review_write'); ?></button>-->
        </div>
    </div>
    <div style="text-align:left; padding-left:2px;"><strong><?php echo $this->lang->line('review_reviews'); ?> </strong>
    </div>
    <?php if (empty($review_count)): ?>
        <div class="ui-bar-c ui-corner-all" style="min-height:20px;font-weight:normal; padding:4px;margin:2px;"
             id="messages-error">
            <span class="error-message form-message"><span class="send-to-name"></span> <?php echo $this->lang->line(
                    'review_no_reviews'
                ); ?></span>
        </div>
    <?php else: ?>
        <div class="ui-bar-c ui-corner-all" style="text-align:left; margin:2px;font-weight:normal; ">
        <?php if (count($reviewDtlArr)): ?>
            <?php
            $count = 0;
            foreach ($reviewDtlArr as $key => $value) :   ?>
                <div id="review-detail-<?= $key ?>" class="ui-bar-c ui-corner-all"
                     style="text-align:left; margin:2px; font-weight:normal; ">
                    <img class="ui-corner-all" style="float:left; padding:2px;" height="60" width="60"
                         src="<?php echo $this->config->item(
                                 'image-profile'
                             ) . $userDtlArr[$value['sender_id']]['upro_image_name'] . '?t=' . time(); ?>">

                    <div style="min-height:63px;">
                        <a href="<?php echo base_url();?>member-profile/<?php echo $userDtlArr[$value['sender_id']]['uacc_id']; ?>"><?php echo $userDtlArr[$value['sender_id']]['upro_name']; ?></a>
                        <br/>

                        <script>

                            $('#rate_user_container_' +<?php echo $count;?>).raty({ readOnly: true, score: <?php echo $value['rating'];?> });

                        </script>
                        <span id="rate_user_container_<?php echo $count; ?>" class="rating_container"></span>
                        <!--<span style="padding: 4px;">
                        <?php for ($i = 0; $i < 5; $i++):
                                  if($userDtlArr[$value['sender_id']]['upro_rating']>$i): ?>
                         <img width="15" height="15" class="seat-avail" src="<?php echo $this->config->item('mobile-image'); ?>full_star.png">
                        <?php     else: ?>
                        <img width="15" height="15" class="seat-avail" src="<?php echo $this->config->item('mobile-image'); ?>empty_star.png">
                        <?php     endif;  ?>
                        <?php  endfor; ?>
                    </span>-->
                    </div>
                    <div class="ui-bar-c ui-corner-all message_text" theme="a"
                         style="margin:2px; font-weight:normal; padding:2px;">
                        <strong><?php echo $this->lang->line('review'); ?></strong> <span
                            style="padding:1px;"><?php echo $value['review_text']; ?></span>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <?php
                $count++;
            endforeach; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>
    <br/>
</div>
<script>
    $(document).ready(function () {
        $('.send-to-name').text($('#ride-owner-name').val());
        $('#rate_user_container_pop').raty({ readOnly: true, score: <?php echo $userDtlArr[$receiver_id]['upro_rating'];?> });
    });
</script>