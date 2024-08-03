<?php


// Register the submenu page
function this_plugin_settings_submenu()
{
    add_options_page(
        'Post Title Required ', // Page title
        'Post Title Required ', // Menu title
        'manage_options',     // Capability required to see the menu
        'post-title-required', // Menu slug
        'post_title_required_setting_page_callback' // Function to display the page content
    );
}
add_action('admin_menu', 'this_plugin_settings_submenu');



// Callback function to display the content of the submenu page
function post_title_required_setting_page_callback()
{
?>
    <div class="wrap">
        <h1>Post Title Required </h1>
        <form method="post" action="options.php">
            <?php
            // Output security fields for the registered setting
            settings_fields('post-title-required-setting');
            // Output setting sections and their fields
            do_settings_sections('post-title-required');
            // Output save settings button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register and define the settings
function plugin_settings_init()
{
    register_setting('post-title-required-setting', 'wp_post_title_character_limit');
    register_setting('post-title-required-setting', 'wp_title_require_post_types');

    $page_slug = 'post-title-required';
    $section_id = 'settigs_fields_section';
    // Register a new section in the "post-title-required" page
    add_settings_section(
        $section_id, // Section ID
        'Post Title Required : General Setting', // Title of the section
        'settings_section_callback', // Callback function to render the section description
        $page_slug // Page slug
    );

    // Register a new field in the "settigs_fields_section" section
    add_settings_field(
        'title_character_limit_settings_field', // Field ID
        'Minimun Post Title Character Limit', // Field title
        'wp_post_title_character_limit_field_callback', // Callback function to render the field
        $page_slug, // Page slug
        $section_id // Section ID
    );

    // Register a new field in the "settigs_fields_section" section
    add_settings_field(
        'title_post_type_settings_field',
        'Select Post Types To Apply Title Character Limit',
        'select_post_type_field_callback',
        $page_slug,
        $section_id
    );
}
add_action('admin_init', 'plugin_settings_init');

// Callback function to render the section description
function settings_section_callback()
{
    echo '';
}

// Callback function to render the field
function wp_post_title_character_limit_field_callback()
{
    $option = (int)get_option('wp_post_title_character_limit');
    if (!$option) {
        $option = 100;
    }
    echo '<input type="number" name="wp_post_title_character_limit" value="' . esc_attr($option) . '"/>';
    echo '<p class="description">Default title character limit is 100.</p>';
}

function select_post_type_field_callback()
{

    $option = (get_option('wp_title_require_post_types')) ?: [];
    $post_types = get_post_types(['public'   => true], 'objects');
    unset($post_types['attachment']);
    foreach ($post_types  as $key => $value) {
        $checked = '';
        if (in_array($value->name, $option)) {
            $checked = 'Checked';
        }
    ?>
        <label for="post-type-<?php echo esc_attr($key); ?>">
            <input type="checkbox" name="wp_title_require_post_types[]" id="post-type-<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value->name); ?>" <?php echo esc_attr($checked); ?>>
            <?php echo esc_attr($value->label); ?>
        </label>
    <?php
    }
    echo '<p class="description">Title required character limit will only apply to selected post type. If all post type are unchecked, it will apply to all post type.</p>';
    ?>
<?php
}
