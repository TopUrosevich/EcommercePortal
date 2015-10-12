<?php
/*
 * Define custom routes. File gets included in the router service definition.
 */
$router = new Phalcon\Mvc\Router();

$router->add('/confirm/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'confirmEmail'
));

$router->add('/reset-password/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'resetPassword'
));

$router->add('/help/manage/categories', array(
    'controller' => 'help',
    'action' => 'manageCategories'
));

$router->add('/help/manage/categoriesEdit/{categoryId}', array(
    'controller' => 'help',
    'action' => 'manageCategoriesEdit'
));

$router->add('/help/manage/delete-categories', array(
    'controller' => 'help',
    'action' => 'deleteCategories'
));

$router->add('/help/manage/swap-categories-order', array(
    'controller' => 'help',
    'action' => 'swapCategoriesOrder'
));

$router->add('/help/manage/topics', array(
    'controller' => 'help',
    'action' => 'manageTopics'
));

$router->add('/help/manage/topicsEdit/{topicId}', array(
    'controller' => 'help',
    'action' => 'manageTopicsEdit'
));

$router->add('/help/manage/delete-topics', array(
    'controller' => 'help',
    'action' => 'deleteTopics'
));

$router->add('/help/manage/swap-topics-order', array(
    'controller' => 'help',
    'action' => 'swapTopicsOrder'
));

$router->add('/help/general/faq', array(
    'controller' => 'help',
    'action' => 'general'
));

$router->add('/help/{category}', array(
    'controller' => 'help',
    'action' => 'category'
));

$router->add('/session/register-company-step1', array(
    'controller' => 'session',
    'action' => 'regCompanyStep1'
));
$router->add('/session/register-company-step2', array(
    'controller' => 'session',
    'action' => 'regCompanyStep2'
));
$router->add('/session/register-company-step2/{action-edit-delete}/{ses_unique}', array(
    'controller' => 'session',
    'action' => 'regCompanyStep2'
));
$router->add('/session/register-company-step3', array(
    'controller' => 'session',
    'action' => 'regCompanyStep3'
));

$router->add('/session/register-contributor', array(
    'controller' => 'session',
    'action' => 'regContributor'
));

$router->add('/contact-us', array(
    'controller' => "contact",
    'action'     => "index"
));

$router->add('/blog/{category}/{article}', array(
    'controller' => 'blog',
    'action' => 'article'
));

$router->add('/blog/{category}', array(
    'controller' => 'blog',
    'action' => 'index'
));

$router->add('/events/filter/:params', array(
    'controller' => 'events',
    'action' => 'index',
    'params' => 1
));
$router->add('/events/{category}/{event}', array(
    'controller' => 'events',
    'action' => 'event'
));
$router->add('/events/contact-organiser', array(
    'controller' => 'events',
    'action' => 'contactOrganiser'
));

$router->add('/companies/{company_name}/gallery/{company_id}', array(
    'controller' => 'companies',
    'action' => 'gallery'
));

$router->add('/companies/{company_name}/{company_id}', array(
    'controller' => 'companies',
    'action' => 'index'
));
$router->add('/companies/{company_id}', array(
    'controller' => 'companies',
    'action' => 'index'
));

$router->add('/companies/contact-supplier', array(
    'controller' => 'companies',
    'action' => 'contactCompany'
));

$router->add('/company/product-list-service-area', array(
    'controller' => 'company',
    'action' => 'productListServiceArea'
));

$router->add('/company/product-list-service-area/{action-edit-delete}/{service_area_id}', array(
    'controller' => 'company',
    'action' => 'productListServiceArea'
));

$router->add('/company/advertising-banner', array(
    'controller' => 'company',
    'action' => 'advertisingBanner'
));

$router->add('/company/create-a-self-service-ad', array(
    'controller' => 'company',
    'action' => 'advertisingSelfService'
));
$router->add('/company/advertising-my-campaigns', array(
    'controller' => 'company',
    'action' => 'advertisingMyCampaigns'
));
$router->add('/company/badge-icon', array(
    'controller' => 'company',
    'action' => 'badgeIcon'
));
$router->add('/company/certification-awards', array(
    'controller' => 'company',
    'action' => 'certificationAwards'
));
$router->add('/company/premium-features', array(
    'controller' => 'company',
    'action' => 'premiumFeatures'
));
$router->add('/company/membership-form', array(
    'controller' => 'company',
    'action' => 'membershipForm'
));

$router->add('/admin-dashboard', array(
    'controller' => 'admin',
    'action' => 'index'
));
$router->add('/admin/manage-users', array(
    'controller' => 'admin',
    'action' => 'manageUsers'
));

// Recipe type: photo or single
$router->add('/recipes/add/{type}', array(
    'controller' => 'recipes',
    'action' => 'add'
));

// Recipe type: photo or single
$router->add('/recipes/add/{type}', array(
    'controller' => 'recipes',
    'action' => 'add'
));

$router->add('/become-a-contributor', array(
    'controller' => 'becomeContributor',
    'action' => 'index'
));


/**
 * Company Message
 */

// message reply
$router->add('/companyMessage/reply/{message_id}', array(
    'controller' => 'companyMessage',
    'action' => 'reply'
));



// message forward
$router->add('/companyMessage/forward/{message_id}', array(
    'controller' => 'companyMessage',
    'action' => 'forward'
));



// message delete
$router->add('/companyMessage/delete/{message_id}', array(
    'controller' => 'companyMessage',
    'action' => 'delete'
));


// message detail
$router->add('/companyMessage/detail/{message_id}', array(
    'controller' => 'companyMessage',
    'action' => 'detail'
));


// trash message page
$router->add('/companyMessage/trash/{page_num}', array(
    'controller' => 'companyMessage',
    'action' => 'trash'
));


// message page
$router->add('/company/messages/{page_num}', array(
    'controller' => 'company',
    'action' => 'messages'
));


// sent message page
$router->add('/companyMessage/sent/{page_num}', array(
    'controller' => 'companyMessage',
    'action' => 'sent'
));


// unread message page
$router->add('/companyMessage/unread/{page_num}', array(
    'controller' => 'companyMessage',
    'action' => 'unread'
));


// detail page reply
$router->add('/companyMessage/detailReply/{reply}', array(
    'controller' => 'companyMessage',
    'action' => 'detailReply'
));



/**
 * User Message
 */

// message reply
$router->add('/userMessage/reply/{message_id}', array(
    'controller' => 'userMessage',
    'action' => 'reply'
));



// message forward
$router->add('/userMessage/forward/{message_id}', array(
    'controller' => 'userMessage',
    'action' => 'forward'
));



// message delete
$router->add('/userMessage/delete/{message_id}', array(
    'controller' => 'userMessage',
    'action' => 'delete'
));


// message detail
$router->add('/userMessage/detail/{message_id}', array(
    'controller' => 'userMessage',
    'action' => 'detail'
));


// trash message page
$router->add('/userMessage/trash/{page_num}', array(
    'controller' => 'userMessage',
    'action' => 'trash'
));


// message page
$router->add('/userMessage/messages/{page_num}', array(
    'controller' => 'userMessage',
    'action' => 'messages'
));


// sent message page
$router->add('/userMessage/sent/{page_num}', array(
    'controller' => 'userMessage',
    'action' => 'sent'
));


// unread message page
$router->add('/userMessage/unread/{page_num}', array(
    'controller' => 'userMessage',
    'action' => 'unread'
));


// detail page reply
$router->add('/userMessage/detailReply/{reply}', array(
    'controller' => 'userMessage',
    'action' => 'detailReply'
));



return $router;
