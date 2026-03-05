<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Crm;
use App\Http\Controllers\layouts\CollapsedMenu;
use App\Http\Controllers\layouts\ContentNavbar;
use App\Http\Controllers\layouts\ContentNavSidebar;
use App\Http\Controllers\layouts\NavbarFull;
use App\Http\Controllers\layouts\NavbarFullSidebar;
use App\Http\Controllers\layouts\Horizontal;
use App\Http\Controllers\layouts\Vertical;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\front_pages\Landing;
use App\Http\Controllers\front_pages\Pricing;
use App\Http\Controllers\front_pages\Payment;
use App\Http\Controllers\front_pages\Checkout;
use App\Http\Controllers\front_pages\HelpCenter;
use App\Http\Controllers\front_pages\HelpCenterArticle;
use App\Http\Controllers\apps\Email;
use App\Http\Controllers\apps\Chat;
use App\Http\Controllers\apps\Calendar;
use App\Http\Controllers\apps\Kanban;
use App\Http\Controllers\apps\EcommerceDashboard;
use App\Http\Controllers\apps\EcommerceProductList;
use App\Http\Controllers\apps\EcommerceProductAdd;
use App\Http\Controllers\apps\EcommerceProductCategory;
use App\Http\Controllers\apps\EcommerceOrderList;
use App\Http\Controllers\apps\EcommerceOrderDetails;
use App\Http\Controllers\apps\EcommerceCustomerAll;
use App\Http\Controllers\apps\EcommerceCustomerDetailsOverview;
use App\Http\Controllers\apps\EcommerceCustomerDetailsSecurity;
use App\Http\Controllers\apps\EcommerceCustomerDetailsBilling;
use App\Http\Controllers\apps\EcommerceCustomerDetailsNotifications;
use App\Http\Controllers\apps\EcommerceManageReviews;
use App\Http\Controllers\apps\EcommerceReferrals;
use App\Http\Controllers\apps\EcommerceSettingsDetails;
use App\Http\Controllers\apps\EcommerceSettingsPayments;
use App\Http\Controllers\apps\EcommerceSettingsCheckout;
use App\Http\Controllers\apps\EcommerceSettingsShipping;
use App\Http\Controllers\apps\EcommerceSettingsLocations;
use App\Http\Controllers\apps\EcommerceSettingsNotifications;
use App\Http\Controllers\apps\AcademyDashboard;
use App\Http\Controllers\apps\AcademyCourse;
use App\Http\Controllers\apps\AcademyCourseDetails;
use App\Http\Controllers\apps\LogisticsDashboard;
use App\Http\Controllers\apps\LogisticsFleet;
use App\Http\Controllers\apps\InvoiceList;
use App\Http\Controllers\apps\InvoicePreview;
use App\Http\Controllers\apps\InvoicePrint;
use App\Http\Controllers\apps\InvoiceEdit;
use App\Http\Controllers\apps\InvoiceAdd;
use App\Http\Controllers\apps\UserList;
use App\Http\Controllers\apps\UserViewAccount;
use App\Http\Controllers\apps\UserViewSecurity;
use App\Http\Controllers\apps\UserViewBilling;
use App\Http\Controllers\apps\UserViewNotifications;
use App\Http\Controllers\apps\UserViewConnections;
use App\Http\Controllers\apps\AccessRoles;
use App\Http\Controllers\apps\AccessPermission;
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\pages\UserTeams;
use App\Http\Controllers\pages\UserProjects;
use App\Http\Controllers\pages\UserConnections;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsSecurity;
use App\Http\Controllers\pages\AccountSettingsBilling;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\Faq;
use App\Http\Controllers\pages\Pricing as PagesPricing;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\pages\MiscComingSoon;
use App\Http\Controllers\pages\MiscNotAuthorized;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\LoginCover;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\RegisterCover;
use App\Http\Controllers\authentications\RegisterMultiSteps;
use App\Http\Controllers\authentications\VerifyEmailBasic;
use App\Http\Controllers\authentications\VerifyEmailCover;
use App\Http\Controllers\authentications\ResetPasswordBasic;
use App\Http\Controllers\authentications\ResetPasswordCover;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\ForgotPasswordCover;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;
use App\Http\Controllers\wizard_example\Checkout as WizardCheckout;
use App\Http\Controllers\wizard_example\PropertyListing;
use App\Http\Controllers\wizard_example\CreateDeal;
use App\Http\Controllers\modal\ModalExample;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\cards\CardAdvance;
use App\Http\Controllers\cards\CardStatistics;
use App\Http\Controllers\cards\CardAnalytics;
use App\Http\Controllers\cards\CardActions;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\Avatar;
use App\Http\Controllers\extended_ui\BlockUI;
use App\Http\Controllers\extended_ui\DragAndDrop;
use App\Http\Controllers\extended_ui\MediaPlayer;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\StarRatings;
use App\Http\Controllers\extended_ui\SweetAlert;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\extended_ui\TimelineBasic;
use App\Http\Controllers\extended_ui\TimelineFullscreen;
use App\Http\Controllers\extended_ui\Tour;
use App\Http\Controllers\extended_ui\Treeview;
use App\Http\Controllers\extended_ui\Misc;
use App\Http\Controllers\icons\Tabler;
use App\Http\Controllers\icons\FontAwesome;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_elements\CustomOptions;
use App\Http\Controllers\form_elements\Editors;
use App\Http\Controllers\form_elements\FileUpload;
use App\Http\Controllers\form_elements\Picker;
use App\Http\Controllers\form_elements\Selects;
use App\Http\Controllers\form_elements\Sliders;
use App\Http\Controllers\form_elements\Switches;
use App\Http\Controllers\form_elements\Extras;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\form_layouts\StickyActions;
use App\Http\Controllers\form_wizard\Numbered as FormWizardNumbered;
use App\Http\Controllers\form_wizard\Icons as FormWizardIcons;
use App\Http\Controllers\form_validation\Validation;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\tables\DatatableBasic;
use App\Http\Controllers\tables\DatatableAdvanced;
use App\Http\Controllers\tables\DatatableExtensions;
use App\Http\Controllers\charts\ApexCharts;
use App\Http\Controllers\charts\ChartJs;
use App\Http\Controllers\maps\Leaflet;
use App\Http\Controllers\laravel_example\UserManagement;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Dashboard
Route::get('/', [Analytics::class, 'index'])->name('dashboard');
Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');

// Locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

// Layouts
Route::prefix('layouts')->name('layouts-')->group(function () {
    Route::get('/collapsed-menu', [CollapsedMenu::class, 'index'])->name('collapsed-menu');
    Route::get('/content-navbar', [ContentNavbar::class, 'index'])->name('content-navbar');
    Route::get('/content-nav-sidebar', [ContentNavSidebar::class, 'index'])->name('content-nav-sidebar');
    Route::get('/navbar-full', [NavbarFull::class, 'index'])->name('navbar-full');
    Route::get('/navbar-full-sidebar', [NavbarFullSidebar::class, 'index'])->name('navbar-full-sidebar');
    Route::get('/horizontal', [Horizontal::class, 'index'])->name('horizontal');
    Route::get('/vertical', [Vertical::class, 'index'])->name('vertical');
    Route::get('/without-menu', [WithoutMenu::class, 'index'])->name('without-menu');
    Route::get('/without-navbar', [WithoutNavbar::class, 'index'])->name('without-navbar');
    Route::get('/fluid', [Fluid::class, 'index'])->name('fluid');
    Route::get('/container', [Container::class, 'index'])->name('container');
    Route::get('/blank', [Blank::class, 'index'])->name('blank');
});

// Front Pages
Route::prefix('front-pages')->name('front-pages-')->group(function () {
    Route::get('/landing', [Landing::class, 'index'])->name('landing');
    Route::get('/pricing', [Pricing::class, 'index'])->name('pricing');
    Route::get('/payment', [Payment::class, 'index'])->name('payment');
    Route::get('/checkout', [Checkout::class, 'index'])->name('checkout');
    Route::get('/help-center', [HelpCenter::class, 'index'])->name('help-center');
    Route::get('/help-center-article', [HelpCenterArticle::class, 'index'])->name('help-center-article');
});

// Apps
Route::prefix('app')->name('app-')->group(function () {
    Route::get('/email', [Email::class, 'index'])->name('email');
    Route::get('/chat', [Chat::class, 'index'])->name('chat');
    Route::get('/calendar', [Calendar::class, 'index'])->name('calendar');
    Route::get('/kanban', [Kanban::class, 'index'])->name('kanban');

    // Ecommerce
    Route::prefix('ecommerce')->name('ecommerce-')->group(function () {
        Route::get('/dashboard', [EcommerceDashboard::class, 'index'])->name('dashboard');
        Route::get('/product/list', [EcommerceProductList::class, 'index'])->name('product-list');
        Route::get('/product/add', [EcommerceProductAdd::class, 'index'])->name('product-add');
        Route::get('/product/category', [EcommerceProductCategory::class, 'index'])->name('product-category');
        Route::get('/order/list', [EcommerceOrderList::class, 'index'])->name('order-list');
        Route::get('/order/details', [EcommerceOrderDetails::class, 'index'])->name('order-details');
        Route::get('/customer/all', [EcommerceCustomerAll::class, 'index'])->name('customer-all');
        Route::get('/customer/details/overview', [EcommerceCustomerDetailsOverview::class, 'index'])->name('customer-details-overview');
        Route::get('/customer/details/security', [EcommerceCustomerDetailsSecurity::class, 'index'])->name('customer-details-security');
        Route::get('/customer/details/billing', [EcommerceCustomerDetailsBilling::class, 'index'])->name('customer-details-billing');
        Route::get('/customer/details/notifications', [EcommerceCustomerDetailsNotifications::class, 'index'])->name('customer-details-notifications');
        Route::get('/manage/reviews', [EcommerceManageReviews::class, 'index'])->name('manage-reviews');
        Route::get('/referrals', [EcommerceReferrals::class, 'index'])->name('referrals');
        Route::get('/settings/details', [EcommerceSettingsDetails::class, 'index'])->name('settings-details');
        Route::get('/settings/payments', [EcommerceSettingsPayments::class, 'index'])->name('settings-payments');
        Route::get('/settings/checkout', [EcommerceSettingsCheckout::class, 'index'])->name('settings-checkout');
        Route::get('/settings/shipping', [EcommerceSettingsShipping::class, 'index'])->name('settings-shipping');
        Route::get('/settings/locations', [EcommerceSettingsLocations::class, 'index'])->name('settings-locations');
        Route::get('/settings/notifications', [EcommerceSettingsNotifications::class, 'index'])->name('settings-notifications');
    });

    // Academy
    Route::prefix('academy')->name('academy-')->group(function () {
        Route::get('/dashboard', [AcademyDashboard::class, 'index'])->name('dashboard');
        Route::get('/course', [AcademyCourse::class, 'index'])->name('course');
        Route::get('/course-details', [AcademyCourseDetails::class, 'index'])->name('course-details');
    });

    // Logistics
    Route::prefix('logistics')->name('logistics-')->group(function () {
        Route::get('/dashboard', [LogisticsDashboard::class, 'index'])->name('dashboard');
        Route::get('/fleet', [LogisticsFleet::class, 'index'])->name('fleet');
    });

    // Invoice
    Route::prefix('invoice')->name('invoice-')->group(function () {
        Route::get('/list', [InvoiceList::class, 'index'])->name('list');
        Route::get('/preview', [InvoicePreview::class, 'index'])->name('preview');
        Route::get('/print', [InvoicePrint::class, 'index'])->name('print');
        Route::get('/edit', [InvoiceEdit::class, 'index'])->name('edit');
        Route::get('/add', [InvoiceAdd::class, 'index'])->name('add');
    });

    // Users
    Route::prefix('user')->name('user-')->group(function () {
        Route::get('/list', [UserList::class, 'index'])->name('list');
        Route::get('/view/account', [UserViewAccount::class, 'index'])->name('view-account');
        Route::get('/view/security', [UserViewSecurity::class, 'index'])->name('view-security');
        Route::get('/view/billing', [UserViewBilling::class, 'index'])->name('view-billing');
        Route::get('/view/notifications', [UserViewNotifications::class, 'index'])->name('view-notifications');
        Route::get('/view/connections', [UserViewConnections::class, 'index'])->name('view-connections');
    });

    Route::get('/access-roles', [AccessRoles::class, 'index'])->name('access-roles');
    Route::get('/access-permission', [AccessPermission::class, 'index'])->name('access-permission');
});

// Pages
Route::prefix('pages')->name('pages-')->group(function () {
    Route::get('/profile-user', [UserProfile::class, 'index'])->name('profile-user');
    Route::get('/profile-teams', [UserTeams::class, 'index'])->name('profile-teams');
    Route::get('/profile-projects', [UserProjects::class, 'index'])->name('profile-projects');
    Route::get('/profile-connections', [UserConnections::class, 'index'])->name('profile-connections');
    Route::get('/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('account-settings-account');
    Route::get('/account-settings-security', [AccountSettingsSecurity::class, 'index'])->name('account-settings-security');
    Route::get('/account-settings-billing', [AccountSettingsBilling::class, 'index'])->name('account-settings-billing');
    Route::get('/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('account-settings-notifications');
    Route::get('/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('account-settings-connections');
    Route::get('/faq', [Faq::class, 'index'])->name('faq');
    Route::get('/pricing', [PagesPricing::class, 'index'])->name('pricing');
    Route::get('/misc-error', [MiscError::class, 'index'])->name('misc-error');
    Route::get('/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('misc-under-maintenance');
    Route::get('/misc-comingsoon', [MiscComingSoon::class, 'index'])->name('misc-comingsoon');
    Route::get('/misc-not-authorized', [MiscNotAuthorized::class, 'index'])->name('misc-not-authorized');
});

// Authentication
Route::prefix('auth')->name('auth-')->group(function () {
    Route::get('/login-basic', [LoginBasic::class, 'index'])->name('login-basic');
    Route::get('/login-cover', [LoginCover::class, 'index'])->name('login-cover');
    Route::get('/register-basic', [RegisterBasic::class, 'index'])->name('register-basic');
    Route::get('/register-cover', [RegisterCover::class, 'index'])->name('register-cover');
    Route::get('/register-multisteps', [RegisterMultiSteps::class, 'index'])->name('register-multisteps');
    Route::get('/verify-email-basic', [VerifyEmailBasic::class, 'index'])->name('verify-email-basic');
    Route::get('/verify-email-cover', [VerifyEmailCover::class, 'index'])->name('verify-email-cover');
    Route::get('/reset-password-basic', [ResetPasswordBasic::class, 'index'])->name('reset-password-basic');
    Route::get('/reset-password-cover', [ResetPasswordCover::class, 'index'])->name('reset-password-cover');
    Route::get('/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('forgot-password-basic');
    Route::get('/forgot-password-cover', [ForgotPasswordCover::class, 'index'])->name('forgot-password-cover');
    Route::get('/two-steps-basic', [TwoStepsBasic::class, 'index'])->name('two-steps-basic');
    Route::get('/two-steps-cover', [TwoStepsCover::class, 'index'])->name('two-steps-cover');
});

// Wizard Examples
Route::prefix('wizard')->name('wizard-ex-')->group(function () {
    Route::get('/ex-checkout', [WizardCheckout::class, 'index'])->name('checkout');
    Route::get('/ex-property-listing', [PropertyListing::class, 'index'])->name('property-listing');
    Route::get('/ex-create-deal', [CreateDeal::class, 'index'])->name('create-deal');
});

// Modal
Route::get('/modal-examples', [ModalExample::class, 'index'])->name('modal-examples');

// Cards
Route::prefix('cards')->name('cards-')->group(function () {
    Route::get('/basic', [CardBasic::class, 'index'])->name('basic');
    Route::get('/advance', [CardAdvance::class, 'index'])->name('advance');
    Route::get('/statistics', [CardStatistics::class, 'index'])->name('statistics');
    Route::get('/analytics', [CardAnalytics::class, 'index'])->name('analytics');
    Route::get('/actions', [CardActions::class, 'index'])->name('actions');
});

// User Interface
Route::prefix('ui')->name('ui-')->group(function () {
    Route::get('/accordion', [Accordion::class, 'index'])->name('accordion');
    Route::get('/alerts', [Alerts::class, 'index'])->name('alerts');
    Route::get('/badges', [Badges::class, 'index'])->name('badges');
    Route::get('/buttons', [Buttons::class, 'index'])->name('buttons');
    Route::get('/carousel', [Carousel::class, 'index'])->name('carousel');
    Route::get('/collapse', [Collapse::class, 'index'])->name('collapse');
    Route::get('/dropdowns', [Dropdowns::class, 'index'])->name('dropdowns');
    Route::get('/footer', [Footer::class, 'index'])->name('footer');
    Route::get('/list-groups', [ListGroups::class, 'index'])->name('list-groups');
    Route::get('/modals', [Modals::class, 'index'])->name('modals');
    Route::get('/navbar', [Navbar::class, 'index'])->name('navbar');
    Route::get('/offcanvas', [Offcanvas::class, 'index'])->name('offcanvas');
    Route::get('/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('pagination-breadcrumbs');
    Route::get('/progress', [Progress::class, 'index'])->name('progress');
    Route::get('/spinners', [Spinners::class, 'index'])->name('spinners');
    Route::get('/tabs-pills', [TabsPills::class, 'index'])->name('tabs-pills');
    Route::get('/toasts', [Toasts::class, 'index'])->name('toasts');
    Route::get('/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('tooltips-popovers');
    Route::get('/typography', [Typography::class, 'index'])->name('typography');
});

// Extended UI
Route::prefix('extended')->name('extended-')->group(function () {
    Route::get('/ui-avatar', [Avatar::class, 'index'])->name('ui-avatar');
    Route::get('/ui-blockui', [BlockUI::class, 'index'])->name('ui-blockui');
    Route::get('/ui-drag-and-drop', [DragAndDrop::class, 'index'])->name('ui-drag-and-drop');
    Route::get('/ui-media-player', [MediaPlayer::class, 'index'])->name('ui-media-player');
    Route::get('/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('ui-perfect-scrollbar');
    Route::get('/ui-star-ratings', [StarRatings::class, 'index'])->name('ui-star-ratings');
    Route::get('/ui-sweetalert2', [SweetAlert::class, 'index'])->name('ui-sweetalert2');
    Route::get('/ui-text-divider', [TextDivider::class, 'index'])->name('ui-text-divider');
    Route::get('/ui-timeline-basic', [TimelineBasic::class, 'index'])->name('ui-timeline-basic');
    Route::get('/ui-timeline-fullscreen', [TimelineFullscreen::class, 'index'])->name('ui-timeline-fullscreen');
    Route::get('/ui-tour', [Tour::class, 'index'])->name('ui-tour');
    Route::get('/ui-treeview', [Treeview::class, 'index'])->name('ui-treeview');
    Route::get('/ui-misc', [Misc::class, 'index'])->name('ui-misc');
});

// Icons
Route::prefix('icons')->name('icons-')->group(function () {
    Route::get('/tabler', [Tabler::class, 'index'])->name('tabler');
    Route::get('/font-awesome', [FontAwesome::class, 'index'])->name('font-awesome');
});

// Form Elements
Route::prefix('forms')->name('forms-')->group(function () {
    Route::get('/basic-inputs', [BasicInput::class, 'index'])->name('basic-inputs');
    Route::get('/input-groups', [InputGroups::class, 'index'])->name('input-groups');
    Route::get('/custom-options', [CustomOptions::class, 'index'])->name('custom-options');
    Route::get('/editors', [Editors::class, 'index'])->name('editors');
    Route::get('/file-upload', [FileUpload::class, 'index'])->name('file-upload');
    Route::get('/pickers', [Picker::class, 'index'])->name('pickers');
    Route::get('/selects', [Selects::class, 'index'])->name('selects');
    Route::get('/sliders', [Sliders::class, 'index'])->name('sliders');
    Route::get('/switches', [Switches::class, 'index'])->name('switches');
    Route::get('/extras', [Extras::class, 'index'])->name('extras');
});

// Form Layouts
Route::prefix('form')->name('form-')->group(function () {
    Route::get('/layouts-vertical', [VerticalForm::class, 'index'])->name('layouts-vertical');
    Route::get('/layouts-horizontal', [HorizontalForm::class, 'index'])->name('layouts-horizontal');
    Route::get('/layouts-sticky', [StickyActions::class, 'index'])->name('layouts-sticky');
    Route::get('/wizard-numbered', [FormWizardNumbered::class, 'index'])->name('wizard-numbered');
    Route::get('/wizard-icons', [FormWizardIcons::class, 'index'])->name('wizard-icons');
    Route::get('/validation', [Validation::class, 'index'])->name('validation');
});

// Tables
Route::prefix('tables')->name('tables-')->group(function () {
    Route::get('/basic', [TablesBasic::class, 'index'])->name('basic');
    Route::get('/datatables-basic', [DatatableBasic::class, 'index'])->name('datatables-basic');
    Route::get('/datatables-advanced', [DatatableAdvanced::class, 'index'])->name('datatables-advanced');
    Route::get('/datatables-extensions', [DatatableExtensions::class, 'index'])->name('datatables-extensions');
});

// Charts
Route::prefix('charts')->name('charts-')->group(function () {
    Route::get('/apex', [ApexCharts::class, 'index'])->name('apex');
    Route::get('/chartjs', [ChartJs::class, 'index'])->name('chartjs');
});

// Maps
Route::prefix('maps')->name('maps-')->group(function () {
    Route::get('/leaflet', [Leaflet::class, 'index'])->name('leaflet');
});

// Laravel Example
Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
Route::resource('/user-list', UserManagement::class);
