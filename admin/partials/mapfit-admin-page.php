<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mapfit.com
 * @since      1.0.0
 *
 * @package    Mapfit
 * @subpackage Mapfit/admin/partials
 */

?>

<script> mapfit.apikey = "<?php echo esc_js( $apikey ); ?>"; </script>
<div class="mapfitmap"> 
  <div id="webEmbed" ></div>
</div>
