<?php

GFForms::include_addon_framework();
 
class GFMetaIncrementor extends GFAddOn {
 
    protected $_version = GF_ADDON_INCREMENTOR_VERSION;
    protected $_min_gravityforms_version = '2.5';
    protected $_slug = 'metaincrementor';
    protected $_path = 'gf-addon-incrementor/gf-addon-incrementor.php';
    protected $_full_path = __FILE__;
    protected $_title = 'Definable Meta Field Auto Incrementor';
    protected $_short_title = 'Auto Incrementor';
 
    /**
     * @var object|null $_instance If available, contains an instance of this class.
     */
    private static $_instance = null;

    /**
     * Returns an instance of this class, and stores it in the $_instance property.
     *
     * @return object $_instance An instance of this class.
     */
    public static function get_instance() {
        if ( self::$_instance == null ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function init() {
        parent::init();
        add_action( 'gform_pre_submission', array( $this, 'pre_submission' ), 10, 2 );
        add_action( 'gform_after_save_form', array( $this, 'add_hidden_field' ), 10, 2 );
        add_action( 'gform_post_update_form_meta', array( $this, 'add_hidden_field' ), 10, 2 );
    }
 
    public function form_settings_fields( $form ) {
        return array(
            array(
                'title'  => esc_html__( 'Meta Field Auto Incrementor Settings', $this->_slug ),
                'fields' => array(
                    array(
                        'name'        => 'enabled',
                        'type'        => 'select',
                        'label'       => esc_html__( 'Enabled?', $this->_slug ),
                        'default_value' => 'false',
                        'choices'     => array(
                            array(
                                'label' => esc_html__( 'Enabled', $this->_slug ),
                                'value' => 'true'
                            ),
                            array(
                                'label' => esc_html__( 'Disabled', $this->_slug ),
                                'value' => 'false'
                            )
                        ),
                    ),
                    array(
                        'type'    => 'text',
                        'name'    => 'label',
                        'label'   => esc_html__( 'Field Label', $this->_slug ),
                        'tooltip' => esc_html__( 'The displayed field label.', $this->_slug ),
                        'default_value' => 'Submission Index',
                        'class'   => 'medium',
                    ),
                    array(
                        'type'    => 'text',
                        'name'    => 'submission_index',
                        'label'   => esc_html__( 'Auto-incremented Submission Index', $this->_slug ),
                        'tooltip' => esc_html__( 'The definable auto-incrementing index of this form.', $this->_slug ),
                        'default_value' => '1',
                        'class'   => 'medium',
                    ),
                    array(
                        'type'    => 'text',
                        'name'    => 'prefix',
                        'label'   => esc_html__( 'Prefix', $this->_slug ),
                        'tooltip' => esc_html__( 'The index prefix.', $this->_slug ),
                        'default_value' => '',
                        'class'   => 'medium',
                    ),
                    array(
                        'type'    => 'text',
                        'name'    => 'postfix',
                        'label'   => esc_html__( 'Postfix', $this->_slug ),
                        'tooltip' => esc_html__( 'The index postfix.', $this->_slug ),
                        'default_value' => '',
                        'class'   => 'medium',
                    ),
                ),
            ),
        );
    }

    public function scripts() {
        $scripts = array(
            array(
                'handle'    => 'gf_readonly_js',
                'src'       => GF_ADDON_INCREMENTOR_URL . 'admin/js/gf-addon-incrementor-admin.js',
                'version'   => $this->_version,
                'deps'      => array(),
                'in_footer' => true,
                'enqueue'   => array(
                    array(
                        'admin_page' => array( 'form_editor' ),
                    )
                )
            ),
        );
     
        return array_merge( parent::scripts(), $scripts );
    }

    public function add_hidden_field( $form, $is_new ) {
        $settings = $this->get_form_settings( $form );
        if ( isset( $settings['enabled'] ) && 'false' != $settings['enabled'] ) {
            // Only add the field to forms that have the setting enabled.
            $submissionIndexField = $this->get_field_by_label( $form, $settings['label'] );
            if ( $is_new || false == $submissionIndexField ) {
                $new_field_id = GFFormsModel::get_next_field_id( $form['fields'] );
                $form['fields'][] = array(
                    'type'         => 'hidden',
                    'label'        => $settings['label'],
                    'id'           => $new_field_id,
                    'defaultValue' => 0,
                    'formId'       => $form['id'],
                    'cssClass'     => 'gf_readonly',
                );
                GFAPI::update_form( $form );
            }
        }
    }

    /** 
     * Gets, increments, and saves the submission index upon every form submission. 
     */
    public function pre_submission( $form ) {
        $settings = $this->get_form_settings( $form );
        if ( isset( $settings['enabled'] ) && 'false' != $settings['enabled'] ) {
            // Fill the hidden field with the correct pre and postfixed index.
            $submissionIndexField = $this->get_field_by_label( $form, $settings['label'] );
            $id = $submissionIndexField['id'];
            $_POST["input_{$id}"] = $this->nextIndex( $form );
        }
    }

    private function nextIndex( $form ) {
        $settings = $this->get_form_settings( $form );
        if ( ! isset( $settings['submission_index'] ) ) throw new Error( 'Error: submission_index is not set!' );
        // Increment the index in forms settings.
        ++$settings['submission_index'];
        // Build formatted index string
        $index = "{$settings['prefix']}{$settings['submission_index']}{$settings['postfix']}";
        $this->save_form_settings( $form, $settings );
        return $index;
    }

    private function get_field_by_label( $form, $label ) {
        foreach( $form['fields'] as $field ) {
            if( $field->label === $label ) {
                return $field;
            }
        }
        return false;
    }
 
}