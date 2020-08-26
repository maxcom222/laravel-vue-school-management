

<input type="hidden" id="post_id" value="<?php echo $result[0] -> id;?>" />


<post-detail :full-path="fullPath"

             :post="{{ json_encode( $result[0] ) }}"
>


</post-detail>




