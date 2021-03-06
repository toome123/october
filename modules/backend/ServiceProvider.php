<?php namespace Backend;

use App;
use Lang;
use Backend;
use BackendMenu;
use BackendAuth;
use Backend\Classes\WidgetManager;
use October\Rain\Support\ModuleServiceProvider;
use System\Models\EmailTemplate;
use System\Classes\SettingsManager;

class ServiceProvider extends ModuleServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register('backend');

        /*
         * Register widgets
         */
        WidgetManager::instance()->registerFormWidgets(function($manager){
            $manager->registerFormWidget('Backend\FormWidgets\CodeEditor', [
                'label' => 'Code editor',
                'alias' => 'codeeditor'
            ]);
            $manager->registerFormWidget('Backend\FormWidgets\RichEditor', [
                'label' => 'Rich editor',
                'alias' => 'richeditor'
            ]);
            $manager->registerFormWidget('Backend\FormWidgets\FileUpload', [
                'label' => 'File uploader',
                'alias' => 'fileupload'
            ]);

            $manager->registerFormWidget('Backend\FormWidgets\Relation', [
                'label' => 'Relationship',
                'alias' => 'relation'
            ]);
            $manager->registerFormWidget('Backend\FormWidgets\Datepicker', [
                'label' => 'Date picker',
                'alias' => 'datepicker'
            ]);
        });

        /*
         * Register navigation
         */
        BackendMenu::registerCallback(function($manager) {
            $manager->registerMenuItems('October.Backend', [
                'dashboard' => [
                    'label'       => 'backend::lang.dashboard.menu_label',
                    'icon'        => 'icon-home',
                    'url'         => Backend::url('backend'),
                    'permissions' => ['backend.access_dashboard'],
                    'order'       => 1
                ]
            ]);
        });

        /*
         * Register settings
         */
        SettingsManager::instance()->registerCallback(function($manager){
            $manager->registerSettingItems('October.Backend', [
                'editor' => [
                    'label'       => 'backend::lang.editor.menu_label',
                    'description' => 'backend::lang.editor.menu_description',
                    'category'    => 'System',
                    'icon'        => 'icon-code',
                    'url'         => Backend::URL('backend/editorsettings'),
                    'sort'        => 200
                ],
            ]);
        });

        /*
         * Register permissions
         */
        BackendAuth::registerCallback(function($manager) {
            $manager->registerPermissions('October.Backend', [
                'backend.access_dashboard' => ['label' => 'View the dashboard', 'tab' => 'System'],
                'backend.manage_users'     => ['label' => 'Manage other administrators', 'tab' => 'System'],
            ]);
        });

        /*
         * Register email templates
         */
        EmailTemplate::registerCallback(function($template){
            $template->registerEmailTemplates([
                'backend::emails.invite' => 'Invitation for newly created administrators.',
                'backend::emails.restore' => 'Password reset instructions for backend-end administrators.',
            ]);
        });
    }

    /**
     * Bootstrap the module events.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot('backend');
    }

}
