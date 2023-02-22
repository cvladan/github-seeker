<?php
/*
Plugin Name: GitHub Seeker
Plugin URI: https://github.dev/cvladan/github-seeker/
Description: Search plugins and themes on GitHub
Author: cvladan
Version: 0.11
Author URI: https://github.dev/cvladan/github-seeker/
GitHub Plugin URI: https://github.dev/cvladan/github-seeker
GitHub Branch:     master
*/

/* add js and css file to admin plugin */
function wpgit_admin_scripts() { 

    /* Add jQuery that's already built into WordPress */
	wp_enqueue_script('jquery');
	
    /* Add stylesheet CSS */
  	wp_enqueue_style( 'bootstrap-wrapper_CSS', plugins_url('admin/css/bootstrap-wrapper.css', __FILE__) );
    
    /* Add stylesheet CSS */
	wp_enqueue_style( 'wpgit_CSS', plugins_url('admin/css/style.css', __FILE__) );
    
	/* Add js file who need jQuery to work */
	wp_enqueue_script(
		'wpgit_JS', plugin_dir_url( __FILE__ ) . 'admin/js/script.js', 
		array('jquery')
	);
	
}
add_action( 'admin_enqueue_scripts', 'wpgit_admin_scripts' );


/* Plugin setting and post */
function ghs_settings()
{

    /* Get Paths */
    $plugin_dir = plugins_url();
    $plugin_url = plugins_url( '' , __FILE__ ).'/';

    /* Get plugin infos */
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version'];
    $plugin_name = $plugin_data['Name'];
    $plugin_description = $plugin_data['Description'];
    
    
    // http://codex.wordpress.org/ThickBox
    add_thickbox();
    
    ?>

    <!--- Bootstrap --->
    <div class="bootstrap-wrapper wrap">
        <h2>
    <span class="dashicons dashicons-search" style="line-height: inherit;"></span> 
    <?php echo $plugin_description ?>
    </h2>

        <div class="">

            <form id="gitsearch" class="form-inline well">
                <div class="form-group">
                    <input type="text" class="form-control" id="searchgit" name="search" placeholder="Search..." />
                </div>

                <select class="form-control" id="options">
                    <option value="+wordpress+theme+in:name,readme,description" selected>Themes</option>
                    <option value="+wordpress+plugin+in:name,readme,description">Plugins</option>
                    <option value="+wordpress+widget+in:name,readme,description">Widget</option>
                </select>

                <button class="btn btn-primary" type="submit">Search</button>
                <hr>
                <div id="resultsinfos">

                    <span id="nbrresults"></span>
                    <span id="limit_remaining" class="pull-right"></span>
                </div>

            </form>


            <div id="wpgit_results" class="row"></div>

            <div id="pagination">
                <div id="prevnext" class="well">
                    <span>
        <a href="#" id="previous">< PREVIOUS</a>
        </span>
                    <span>
        <span class="separator">|</span>
                    <a href="#" id="Next"> NEXT ></a>
                    </span>
                </div>
            </div>

        </div>


    </div>
    <!--Wrap end -->
    <!--End basic Table -->
    <script type="text/javascript">
        var plugin_url = "<?php echo $plugin_url ; ?>";
    </script>
    <style>
        /* plugin style admin */
        
        .admin_style {
            margin: 10px;
        }

    </style>

    <?php } // End Setting function

# Admin plugin setting
add_action('admin_menu', function ()
{
    add_submenu_page('tools.php', 'GitHub Seeker', 'GitHub Search', 'read', 'github-seeker', 'ghs_settings');
});

# Add link in plugin list
add_filter( 'plugin_action_links', function ( $plugin_links, $plugin_file ) {

    if ($plugin_file !== basename(plugin_dir_path(__FILE__)) . '/index.php') {
        return $plugin_links;
    }

    return array_merge($plugin_links, [ '<a href="' . esc_url(admin_url('tools.php?page=github-seeker')) . '">Search</a>' ] );
}, 10, 2 );