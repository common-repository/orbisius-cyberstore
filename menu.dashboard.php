<?php

$settings_key = $orbisius_digishop_obj->get('plugin_settings_key');
$opts = $orbisius_digishop_obj->get_options();

$plugin_file = dirname(__FILE__) . '/orbisius-cyberstore.php';

?>
<div class="wrap">
        <h2>Orbisius CyberStore &rarr; Dashboard</h2>

        <div class="updated"><p>
            <?php if (!empty($_REQUEST['settings-updated'])) : ?>
               <strong>Settings saved.</strong>
            <?php else : ?>
               Orbisius CyberStore plugin allows you to start selling your digital products such as e-books, reports in minutes.
            <?php endif; ?>
        </p></div>

        <div id="poststuff">

            <div id="post-body" class="metabox-holder columns-2">

                <!-- main content -->
                <div id="post-body-content">

                    <div class="meta-box-sortables ui-sortable">

                        <div class="postbox">
                            <div class="inside">
                                <form method="post" action="options.php">
									<?php settings_fields($orbisius_digishop_obj->get('plugin_dir_name')); ?>
									<table class="form-table">
										<tr valign="top">
											<th scope="row"></th>
											<td>
								
                                                <a href="<?php echo $orbisius_digishop_obj->get('plugin_admin_url_prefix') . '/menu.product.add.php';?>"
                                   title=""
                                    class="button-primary">Add Product</a>
                                                |
                                                <a href="<?php echo $orbisius_digishop_obj->get('plugin_admin_url_prefix') . '/menu.products.php';?>"
                                   title=""
                                    class="button-primary">Products</a>
                                                |
                                                <a href="<?php echo $orbisius_digishop_obj->get('plugin_admin_url_prefix') . '/menu.settings.php';?>"
                                   title=""
                                    class="button">Settings</a>
                                                |
                                                <a href="http://orbisius.com/forums/forum/community-support-forum/wordpress-plugins/orbisius-cyberstore/?utm_source=orbisius-cyberstore&utm_medium=plugin-dashboard&utm_campaign=product"
                                   title="Support forums. This opens in a new window/tab"
                                   class="button" target="_blank">Support Forums</a>
                                                |
                                                <a href="http://orbisius.com/products/wordpress-plugins/orbisius-cyberstore/extensions/?utm_source=<?php echo str_replace('.php', '', basename($plugin_file));?>&utm_medium=plugin-dashboard&utm_campaign=product"
                                   title="If you want to get some extesions for the plugin. This opens in a new window/tab"
                                    class="button" target="_blank">Get Extensions</a>
                                                |
                                                <a href="http://www.youtube.com/playlist?list=PLfGsyhWLtLLiCa3WleGdArmG1RU6w9Ug5"
                                   title="If you want to get some extesions for the plugin. This opens in a new window/tab"
                                    class="button" target="_blank">Video Tutorials</a>
											</td>
										</tr>
									</table>
								</form>
                            </div> <!-- .inside -->

                        </div> <!-- .postbox -->

                        <div class="postbox">
                            <h3><span>Tell Your Friends</span></h3>
                            <div class="inside">
                                <?php
                                    $plugin_data = get_plugin_data($plugin_file);

                                    $app_link = urlencode($plugin_data['PluginURI']);
                                    $app_title = urlencode($plugin_data['Name']);
                                    $app_descr = urlencode($plugin_data['Description']);
                                ?>
                                <p>
                                    <!-- AddThis Button BEGIN -->
                                    <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                                        <a class="addthis_button_facebook" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_twitter" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_google_plusone" g:plusone:count="false" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_linkedin" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_email" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_myspace" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_google" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_digg" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_delicious" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_stumbleupon" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_tumblr" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_favorites" addthis:url="<?php echo $app_link?>" addthis:title="<?php echo $app_title?>" addthis:description="<?php echo $app_descr?>"></a>
                                        <a class="addthis_button_compact"></a>
                                    </div>
                                    <!-- The JS code is in the footer -->

                                    <script type="text/javascript">
                                    var addthis_config = {"data_track_clickback":true};
                                    var addthis_share = {
                                      templates: { twitter: 'Check out {{title}} at {{lurl}} (from @orbisius)' }
                                    }
                                    </script>
                                    <!-- AddThis Button START part2 -->
                                    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>
                                    <!-- AddThis Button END part2 -->
                                </p>
                            </div> <!-- .inside -->

                        </div> <!-- .postbox -->

                        <div class="postbox">
                            <h3><span>Donate</span></h3>
                            <div class="inside">
                                <?php
                                    echo $orbisius_digishop_obj->generate_donate_box();
                                ?>
                            </div> <!-- .inside -->
                        </div> <!-- .postbox -->

                    </div> <!-- .meta-box-sortables .ui-sortable -->

                </div> <!-- post-body-content -->

                <!-- sidebar -->
                <div id="postbox-container-1" class="postbox-container">

                    <div class="meta-box-sortables">
                        <?php Orbisius_CyberStoreUtil::output_plugin_sidebar(); ?>
                    </div> <!-- .meta-box-sortables -->

                </div> <!-- #postbox-container-1 .postbox-container -->

            </div> <!-- #post-body .metabox-holder .columns-2 -->

            <br class="clear">
        </div> <!-- #poststuff -->
</div> <!-- /wrap -->
