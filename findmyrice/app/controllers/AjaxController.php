<?php
namespace Findmyrice\Controllers;

require_once BASE_DIR . '/app/vendor/aws/aws-autoloader.php';

use Phalcon\Tag;
use Phalcon\Mvc\Collection;
use Findmyrice\Models\Users;
use Findmyrice\Models\Profile;
use Findmyrice\Models\Gallery;
use Findmyrice\Models\ProductList;
use Aws\S3\S3Client;
use \Phalcon\Image\Adapter\GD as GdAdapter;
use Phalcon\Http\Response;
use MongoId;
use Findmyrice\Models\FavoritesCompanies;
use Symfony\Component\Process\Process;
use Findmyrice\Models\ElasticSearchModel;
use Elasticsearch;
/**
 * Findmyrice\Controllers\UsersController
 * CRUD to manage users
 */
class AjaxController extends ControllerBase
{

    public function initialize()
    {
        $this->view->disable();
    }

    public function logoUploadAction()
    {
        // use the request to check for post
        if ($this->request->isPost() == true) {
            $response = new Response();
            $content = array();
            // Check whether the request was made with Ajax
            if ($this->request->isAjax() == true) {
                $userID  = $this->request->getPost('user_id');
                $id = $this->request->getPost('id');
                $identity = $this->session->get('auth-identity');
                $user_id = $identity['id'];
                $user_profile = $identity['profile'];

                if($user_profile != 'Administrators' && $user_id != $id){
                    $id = $user_id;
                }

                $user = Users::findById($id);
                $profile = Profile::findByUserId($userID);

                if (!$user) {
                    die("User/Company was not found");
                }
//                if (!$profile) {
//                    die("Profile was not found");
//                }
                $client = S3Client::factory(array(
                    'key'    => $this->config->amazon->AWSAccessKeyId,
                    'secret' => $this->config->amazon->AWSSecretKey,
                    'region' => 'us-west-2'
                ));
                $uploads = $this->request->getUploadedFiles();
                $bucket = 'findmyrice';
                #do a loop to handle each file individually
                if($uploads){
                    $upload = $uploads[0];
                    $image_key = $upload->getKey();
                    $unique_name = md5(uniqid(rand(), true)).'-'.strtolower($upload->getname());
                    if($user_profile == 'Users'){
                        $key = 'users/'.$user->_id.'/'.$unique_name;

                    }else if($user_profile == 'Companies'){
                        $key = 'companies/'.$user->_id.'/'.$unique_name;
                    }else{
                        $key = '';
                    }

                    // Upload an object by streaming the contents of a file
                    // pathToFile should be absolute path to a file on disk
                    $result = $client->putObject(array(
                        'Bucket'     => $bucket,
                        'Key'        => $key,
                        'SourceFile' => $upload->getRealPath(),
                        'ACL'=> 'public-read',
                        'ContentType'     => 'text/plain'
                    ));
                    if($image_key == 'logoToUpload'){
                        $user->logo = $result['ObjectURL'];
                        if($profile){
                            $profile->logo = $result['ObjectURL'];
                        }

                    }elseif($image_key == 'imageToUpload'){
                        if($profile){
                            $profile->profile_image = $result['ObjectURL'];
                        }
                    }

                    $content['original_image'] = $result['ObjectURL'];


                    //Make thumbnails
                    $imageSizeArray = array(
                        0 =>array('width'=>140, 'height'=>140),
                        1 =>array('width'=>200, 'height'=>180),
                        2 =>array('width'=>290, 'height'=>190),
                        3 =>array('width'=>266, 'height'=>300)
                    );
                    for($i=0; $i < count($imageSizeArray);$i++){
                        $image[$i] = new GdAdapter($upload->getRealPath());
                        if($user_profile == 'Users') {
                            $key_thumb = 'users/' . $user->_id . '/' . 'thumb_' . $imageSizeArray[$i]['width'] . 'x' . $imageSizeArray[$i]['height'] . '_' . $unique_name;
                        }else if($user_profile == 'Companies'){
                            $key_thumb = 'companies/' . $user->_id . '/' . 'thumb_' . $imageSizeArray[$i]['width'] . 'x' . $imageSizeArray[$i]['height'] . '_' . $unique_name;
                        }else{
                            $key_thumb = 'thumb_' . $imageSizeArray[$i]['width'] . 'x' . $imageSizeArray[$i]['height'] . '_' . $unique_name;
                        }
                        $image[$i]->resize($imageSizeArray[$i]['width'], $imageSizeArray[$i]['height']);
                        $file_dir = BASE_DIR .'/public/tmp/'. $user->_id;
                        if(!is_dir($file_dir)){
                            mkdir($file_dir, 0755);
                        }
                        $dir = $file_dir.'/thumb_' . $imageSizeArray[$i]['width'] . 'x' . $imageSizeArray[$i]['height'] . '_' . $unique_name;

                        if($image[$i]->save($dir)){
                            $thumb_ = new GdAdapter($dir);
                            $result_thumb = $client->putObject(array(
                                'Bucket'     => $bucket,
                                'Key'        => $key_thumb,
                                'SourceFile' => $thumb_->getRealPath(),
                                'ACL'=> 'public-read',
                                'ContentType'     => 'text/plain'
                            ));
                            $content['thumb_image_'.$imageSizeArray[$i]['width'].'x'.$imageSizeArray[$i]['height']] = $result_thumb['ObjectURL'];
                            unlink($dir); // delete file
                        }
                        if($i == 3){
                            $this->rrmdir($file_dir); // delete folder
                        }
                    }
                    $res = array();
                    if (!$user->save()) {
                        $res[0] = $user->getMessages();
                    }
                    if($profile){
                        if (!$profile->save()) {
                            $res[1] = $profile->getMessages();
                        }
                    }

                }
                $response->setStatusCode(201, 'Created');
                $response->setHeader('Content-Type', 'application/json');
                $response->setJsonContent(json_encode($content));
                return $response;
            }
        }else{
            // choose to die as that makes it cleaner
            die("Access denied");
        }
    }
    public function galleryUploadAction()
    {
        // use the request to check for post
        if ($this->request->isPost() == true) {
            $response = new Response();
            $content = array();
            // Check whether the request was made with Ajax
            if ($this->request->isAjax() == true) {
                $identity = $this->session->get('auth-identity');
                $user_id = $identity['id'];
                $user_profile = $identity['profile'];

               $client = S3Client::factory(array(
                    'key'    => $this->config->amazon->AWSAccessKeyId,
                    'secret' => $this->config->amazon->AWSSecretKey,
                    'region' => 'us-west-2'
                ));
                $uploads = $this->request->getUploadedFiles();
                $bucket = 'findmyrice';
                $photo_name = '';
                #do a loop to handle each file individually
                foreach($uploads as $u_k => $upload) {
                    $mimeType = $upload->getRealType();
                    $correct_image = false;
                    switch ($mimeType) {
                        case 'image/jpeg':
                            $correct_image = true;
                            break;
                        case 'image/png':
                            $correct_image = true;
                            break;
                        case 'image/gif':
                            $correct_image = true;
                            break;
                    }
                    $file_size = $upload->getSize();
                    $file_size_b = $file_size / 1024;
                    if ($file_size_b <= 500 && $correct_image) {
                        $gallery = new Gallery();
                        $gallery->user_id = new MongoId($user_id);
                        $image_key = $upload->getKey();
                        $unique_name = md5(uniqid(rand(), true)) . '-' . strtolower($upload->getname());
                        if ($user_profile == 'Users') {
                            $key = 'users/' . $user_id . '/gallery/' . $unique_name;
                        } else if ($user_profile == 'Companies') {
                            $key = 'companies/' . $user_id . '/gallery/' . $unique_name;
                        } else {
                            $key = 'gallery';
                        }

                        // Upload an object by streaming the contents of a file
                        // pathToFile should be absolute path to a file on disk
                        $result = $client->putObject(array(
                            'Bucket' => $bucket,
                            'Key' => $key,
                            'SourceFile' => $upload->getRealPath(),
                            'ACL' => 'public-read',
                            'ContentType' => 'text/plain'
                        ));

                        $content['original_image'][] = $result['ObjectURL'];
                        $photo_name = $unique_name;

                        //Make thumbnails
                        $imageSizeArray = array(
                            0 => array('width' => 140, 'height' => 140),
                            1 => array('width' => 200, 'height' => 180),
                            2 => array('width' => 290, 'height' => 190),
                            3 => array('width' => 266, 'height' => 300)
                        );
                        for ($i = 0; $i < count($imageSizeArray); $i++) {
                            $image[$i] = new GdAdapter($upload->getRealPath());
                            if ($user_profile == 'Users') {
                                $key_thumb = 'users/' . $user_id . '/gallery/' . 'thumb_' . $imageSizeArray[$i]['width'] . 'x' . $imageSizeArray[$i]['height'] . '_' . $unique_name;
                            } else if ($user_profile == 'Companies') {
                                $key_thumb = 'companies/' . $user_id . '/gallery/' . 'thumb_' . $imageSizeArray[$i]['width'] . 'x' . $imageSizeArray[$i]['height'] . '_' . $unique_name;
                            } else {
                                $key_thumb = 'thumb_' . $imageSizeArray[$i]['width'] . 'x' . $imageSizeArray[$i]['height'] . '_' . $unique_name;
                            }
                            $image[$i]->resize($imageSizeArray[$i]['width'], $imageSizeArray[$i]['height']);
                            $file_dir = BASE_DIR . '/public/tmp/' . $user_id;
                            if (!is_dir($file_dir)) {
                                mkdir($file_dir, 0755);
                            }
                            $dir = $file_dir . '/thumb_' . $imageSizeArray[$i]['width'] . 'x' . $imageSizeArray[$i]['height'] . '_' . $unique_name;

                            if ($image[$i]->save($dir)) {
                                $thumb_ = new GdAdapter($dir);
                                $result_thumb = $client->putObject(array(
                                    'Bucket' => $bucket,
                                    'Key' => $key_thumb,
                                    'SourceFile' => $thumb_->getRealPath(),
                                    'ACL' => 'public-read',
                                    'ContentType' => 'text/plain'
                                ));
//                                $content['thumb_image_' . $imageSizeArray[$i]['width'] . 'x' . $imageSizeArray[$i]['height']] = $result_thumb['ObjectURL'];
                                unlink($dir); // delete file
                            }
                            if ($i == 3) {
                                $this->rrmdir($file_dir); // delete folder
                            }
                        }
                        $gallery->photo_name = $photo_name;

                        if (!$gallery->save()) {
                            $content['error'][] = $gallery->getMessages();
                        } else {
                            $content['ok'][] = 1;
                        }
                    }else{
                        if($file_size_b > 500){
                            $this->flashSession->error('Some files are too large. Please reduce the file size to 500kb and try again.');
                            $content['file_size'][] = 1;
                        }elseif($correct_image == false){
                            $this->flashSession->error('Some files have no image type.');
                            $content['not_image'][] = 1;
                        }
                    }
                }
                $response->setStatusCode(201, 'Response');
                $response->setHeader('Content-Type', 'application/json');
                $response->setJsonContent(json_encode($content));
                return $response;
            }
        }else{
            // choose to die as that makes it cleaner
            die("Access denied");
        }
    }

    public function productUploadAction()
    {
        $response = new Response();
        // use the request to check for post
        if ($this->request->isPost() == true) {
            // Check whether the request was made with Ajax
            if ($this->request->isAjax() == true) {
                $identity = $this->session->get('auth-identity');
                $user_id = $identity['id'];
                $user_profile = $identity['profile'];

                $client = S3Client::factory(array(
                    'key'    => $this->config->amazon->AWSAccessKeyId,
                    'secret' => $this->config->amazon->AWSSecretKey,
                    'region' => 'us-west-2'
                ));
                #check if there is any file
                if($this->request->hasFiles() == true){
                    $uploads = $this->request->getUploadedFiles();
                    $bucket = 'findmyrice';
                    #do a loop to handle each file individually
                    if($uploads){
                        $product = new ProductList();
                        $product->user_id = new MongoId($user_id);

                        $upload = $uploads[0];
                        $file_key = $upload->getKey();
                        $file_size = $upload->getSize();
                        $file_extension = $upload->getExtension();

                        $unique_name = md5(uniqid(rand(), true)).'-'.strtolower($upload->getname());
                        if($user_profile == 'Users'){
                            $key = 'users/'.$user_id.'/products/'.$unique_name;
                        }else if($user_profile == 'Companies'){
                            $key = 'companies/'.$user_id.'/products/'.$unique_name;
                        }else{
                            $key = 'products';
                        }
                        if($file_extension !='pdf'
                            && $file_extension !='doc'
                            && $file_extension !='docx'
                            && $file_extension !='xls'
                            && $file_extension !='xlsx'
                            && $file_extension !='csv'){

                            $response->setStatusCode(201, 'Extension');
                            $response->setHeader('Content-Type', 'application/json');
                            $response->setJsonContent(json_encode('extension'));
                            return $response;
                        }

                        $inputFileName = $upload->getRealPath();
                        $arrProduct = $this->external->getArrayProductsFromFile($file_extension, $inputFileName);
                        $result = $client->putObject(array(
                            'Bucket'     => $bucket,
                            'Key'        => $key,
                            'SourceFile' => $upload->getRealPath(),
                            'ACL'=> 'public-read',
                            'ContentType'     => 'text/plain'
                        ));
                        $product_list_name = str_replace(".".$file_extension, "", $upload->getname());
                        $product->pl_file_type = $file_extension;
                        $product->pl_name = $product_list_name;
                        $product->pl_size = $file_size;
                        $product->pl_url = $result['ObjectURL'];
                        if($product->save()){
                            //for Elasticsearch
                            $el_productList_params = array();
                            $el_productList_params['index'] = $this->config->elasticSearch->productList->index;
                            $el_productList_params['type']  = $this->config->elasticSearch->productList->type;
                            $el_productList_params['id']    = (string)$product->_id;
                            $el_productList_params['user_id']    = (string)$product->user_id;
                            $el_productList_params['pl_name']    = $product->pl_name;
                            $el_productList_params['pl_name_exact']    = $product->pl_name;
                            $el_productList_params['pl_file_type']    = $product->pl_file_type;
                            $el_productList_params['pl_file_type_exact']    = $product->pl_file_type;
                            $el_productList_params['pl_size']    = $product->pl_size;
                            $el_productList_params['pl_url']    = $product->pl_url;
                            $el_productList_params['pl_uploaded']    = date('Y-m-d',$product->pl_uploaded);
                            $el_productList_params['pl_uploaded_exact']    = date('Y-m-d',$product->pl_uploaded);

                            $encode_ProductList = base64_encode(serialize($el_productList_params));
                            $cmd_ProductList = 'php '.APP_DIR .'/cli.php elastic createIndex ' . $encode_ProductList;
                            $process_ProductList = new Process($cmd_ProductList);
                            $process_ProductList->run();

                            //Products
                            if(!empty($arrProduct)){
                                $el_products_params = array();
                                $el_products_params['index'] = $this->config->elasticSearch->products->index;
                                $el_products_params['type']  = $this->config->elasticSearch->products->type;
                                $el_products_params['product_list_id']    = (string)$product->_id;
                                $el_products_params['user_id']    = (string)$product->user_id;
                                $el_products_params['product_created_at']    = date('Y-m-d',$product->pl_uploaded);
                                $el_products_params['product_modified_at']    = date('Y-m-d',$product->pl_uploaded);
                                $el_products_params['product_modified_at_exact']    = date('Y-m-d',$product->pl_uploaded);
                                $el_products_params['productsData']    = $arrProduct;


                                $el_params = array();
                                foreach($el_products_params["productsData"] as $key=>$val){
                                    $el_params['body'][] = array(
                                        'index' => array(
                                            '_index' => $el_products_params['index'],
                                            '_type' => $el_products_params['type']
                                        )
                                    );
                                    $el_params['body'][] = array(
                                        'user_id' => $el_products_params['user_id'],
                                        'product_list_id' => $el_products_params['product_list_id'],
                                        'product_created_at' => $el_products_params['product_created_at'],
                                        'product_modified_at' => $el_products_params['product_modified_at'],
                                        'product_modified_at_exact' => $el_products_params['product_modified_at_exact'],
                                        'product_name' => $val['product_name'],
                                        'product_name_exact' => $val['product_name'],
                                        'unit_qty' => $val['unit_qty'],
                                        'unit_qty_exact' => $val['unit_qty'],
                                        'brand' => $val['brand'],
                                        'brand_exact' => $val['brand'],
                                        'product_category' => $val['product_category'],
                                        'product_category_exact' => $val['product_category']
                                    );
                                }
                                $client_elastic = new Elasticsearch\Client();
                                if(!empty($el_params)){
                                    $bulk_products_index = $client_elastic->bulk($el_params);
                                }
                            }
                            //end Elasticsearch

                            $response->setStatusCode(201, 'Product List Uploaded');
                            $response->setHeader('Content-Type', 'application/json');
                            $response->setJsonContent(json_encode(1));
                        }else{
                            $response->setStatusCode(201, 'Something went wrong...');
                            $response->setHeader('Content-Type', 'application/json');
                            $response->setJsonContent(json_encode(0));
                        }
                        return $response;
                    }
                    $response->setStatusCode(201, 'Something went wrong...');
                    $response->setHeader('Content-Type', 'application/json');
                    $response->setJsonContent(json_encode(0));
                    return $response;

                } else {
                    $response->setStatusCode(201, 'Something went wrong...');
                    $response->setHeader('Content-Type', 'application/json');
                    $response->setJsonContent(json_encode(0));
                    return $response;
                }
            }
        }else{
            $response->setStatusCode(201, 'Something went wrong...');
            $response->setHeader('Content-Type', 'application/json');
            $response->setJsonContent(json_encode(0));
            return $response;
        }
    }


    public function uploadImageAction()
    {
        if ($this->request->isPost()) {
            $response = new Response();

            $identity = $this->session->get('auth-identity');
            $userId = $identity['id'];
            $userProfile = $identity['profile'];

                $user = Users::findById($userId);

                if ($user) {
                    $client = S3Client::factory(array(
                        'key'    => $this->config->amazon->AWSAccessKeyId,
                        'secret' => $this->config->amazon->AWSSecretKey,
                        'region' => 'us-west-2'
                    ));
                    $uploads = $this->request->getUploadedFiles();
                    $bucket = 'findmyrice';

                    if (!empty($uploads)) {
                        $file = $uploads[0];
                        $uniqueName = time() . '-' . $file->getName();
                        $key = strtolower($userProfile) .'/'. $user->_id . '/' . $uniqueName;

                        $mimeType = $file->getRealType();

                        switch ($mimeType) {
                            case 'image/jpeg':
                                $image = imagecreatefromjpeg($file->getRealPath());
                                break;
                            case 'image/png':
                                $image = imagecreatefrompng($file->getRealPath());
                                break;
                            default:
                                $image = null;
                        }

                        if ($image) {
                            $tmp = tempnam(null, null);
                            imagejpeg($image, $tmp, 100);
                            imagedestroy($image);

                            $result = $client->putObject(array(
                                'Bucket'     => $bucket,
                                'Key'        => $key,
                                'ACL'=> 'public-read',
                                'SourceFile' => $tmp,
                                'ContentType'     => 'image/jpeg'
                            ));

                            unlink($tmp);

                            if ($result) {
                                $content = array(
                                    'image' => array(
                                        'key' => $key,
                                        'url' => $result['ObjectURL']
                                    )
                                );
                                $response->setStatusCode(201, 'Created');
                                $response->setHeader('Content-Type', 'application/json');
                                $response->setJsonContent(json_encode($content));
                            }
                        }
                    }
                }
            return $response;
        }
    }

    public function removeImageAction()
    {
        if ($this->request->isPost()) {
            $response = new Response();

            $identity = $this->session->get('auth-identity');
            $userId = $identity['id'];
            $userProfile = $identity['profile'];

            $user = Users::findById($userId);
            $profile = Profile::findByUserId($userId);

            if (!$profile && $userProfile != 'Users') {
                $response->setStatusCode(201, 'No Profile');
                $response->setHeader('Content-Type', 'application/json');
                $response->setJsonContent(json_encode(0));
                return $response;
            }
            if ($user) {

                $r_img = $this->request->getPost('close_id');
                if($r_img == "image_remove" && $userProfile != 'Users'){
                    $profile->profile_image = '';
                    if($profile->save()){
                        $response->setStatusCode(201, 'Removed');
                        $response->setHeader('Content-Type', 'application/json');
                        $response->setJsonContent(json_encode('profile_image'));
                    }else{
                        $response->setStatusCode(201, 'No' );
                        $response->setHeader('Content-Type', 'application/json');
                        $response->setJsonContent(json_encode(0));
                    }

                }elseif($r_img == "logo_remove"){
                    $user->logo = '';
                    if($profile){
                        $profile->logo = '';
                    }

                    if($user->save()){
                        if($profile){
                            $profile->save();
                        }
                        $response->setStatusCode(201, 'Removed');
                        $response->setHeader('Content-Type', 'application/json');
                        $response->setJsonContent(json_encode('logo'));
                    }else{
                        $response->setStatusCode(201, 'No' );
                        $response->setHeader('Content-Type', 'application/json');
                        $response->setJsonContent(json_encode(0));
                    }
                }else{
                    $response->setStatusCode(201, 'Something wrong...' );
                    $response->setHeader('Content-Type', 'application/json');
                    $response->setJsonContent(json_encode(0));
                }
            }
            return $response;
        }
    }

    public function removeGalleryImageAction()
    {
        if ($this->request->isPost()) {

            if ($this->request->isAjax() == true) {
                $response = new Response();
                $identity = $this->session->get('auth-identity');
                $userId = $identity['id'];
                $userProfile = $identity['profile'];

                    $r_img = $this->request->getPost('remove_image_id');

                    try{
                        $photo = Gallery::findById($r_img);
                        if($userId == (string)$photo->user_id) {
                            if ($photo->delete()) {
                                $response->setStatusCode(201, 'Removed');
                                $response->setHeader('Content-Type', 'application/json');
                                $response->setJsonContent(json_encode('removed'));
                            } else {
                                $response->setStatusCode(201, 'Something wrong...');
                                $response->setHeader('Content-Type', 'application/json');
                                $response->setJsonContent(json_encode('cannot_remove'));
                            }
                            return $response;
                        } else {
                            $response->setStatusCode(201, 'User Error');
                            $response->setHeader('Content-Type', 'application/json');
                            $response->setJsonContent(json_encode('user_error'));
                            return $response;
                        }

                    }catch (\Exception $er){
                        $response->setStatusCode(201, 'Cannot remove');
                        $response->setHeader('Content-Type', 'application/json');
                        $response->setJsonContent(json_encode('cannot_remove'));
                        return $response;
                    }
                return $response;
            }
        }
    }
    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function getSimilarCompanies(){
        //Ajax pagination Similar Companies
        if($this->request->isPost()){
            if($this->request->isAjax()){
                $ajax_similar_companies_page_int = $this->request->getPost('ajax_similar_companies_page_int');
                $ajax_profilesId = $this->request->getPost('ajax_profilesId');
                $ajax_business_type = $this->request->getPost('ajax_business_type');
                $ajax_conditions = array(
                    array(
                        'active' => 'Y',
                        'profilesId'=> $ajax_profilesId,
                        'business_type' => $ajax_business_type,
                    ),
                    'sort' => array(
                        'start_date' => 1
                    )
                );

                $ajax_similar_companies = Users::find($ajax_conditions);

                $ajax_paginator = new Paginator(array(
                    'data' => $ajax_similar_companies,
                    'limit' => 4,
                    'page' => $ajax_similar_companies_page_int
                ));

                $ajax_page = $ajax_paginator->getPaginate();

                $sCompanis_profile = array();
                $arr_company = array();
                foreach($ajax_page->items as $key=>$item){
                    $profile_c = Profile::findByUserId($item->_id);
                    if($profile_c){
                        $arr_company[$key] = $item->toArray();
                        $sCompanis_profile[$key] = $profile_c->toArray();
                    }
                    if(count($sCompanis_profile) == 4){
                        break;
                    }
                }
                $similarCompaniesProfiles = array();
                foreach($sCompanis_profile as $key=>$sCompany_p){
                    if($sCompany_p){
                        $similarCompaniesProfiles[$key]['user']  = $arr_company[$key];
                        $similarCompaniesProfiles[$key]['profile']  = $sCompanis_profile[$key];
                    }
                }
                echo json_encode($similarCompaniesProfiles);
                exit;
            }
        }
        //Ajax pagination Similar Companies End
    }

    /**
     * Like company using AJAX
     */
    public function likeCompanyAction()
    {
        if($this->request->isPost()){
            if($this->request->isAjax()){

                $response = new Response();

                $identity = $this->session->get('auth-identity');
                $userProfile = $identity['profile'];
                $userId = $identity['id'];
                $companyId = $this->request->getPost('company_id', 'string');

                if (!($userProfile == 'Users' || $userProfile == 'Administrators')) {
                    $response->setHeader('Redirect', '/session/login');
                    $response->setStatusCode(401, 'Unauthorized');
                    return $response;
                }

                $company = Users::findById($companyId);

                if ($company) {
                    $favoriteCompany = FavoritesCompanies::findFirst(array(
                        array(
                            'company_id' => $companyId,
                            'user_id' => $userId
                        )
                    ));

                    if (!$favoriteCompany) {
                        $favoriteCompany = new FavoritesCompanies();
                        $favoriteCompany->company_id = $companyId;
                        $favoriteCompany->user_id = $userId;

                        if ($favoriteCompany->save()) {
                            $response->setStatusCode(201, 'Created');
                            return $response;
                        }
                    }
                }

                $response->setStatusCode(400, 'Bad Request');

                return $response;


            }
        }

    }

    public function getStatesAction(){

        if($this->request->isPost()){

            if($this->request->isAjax()) {

                $country = $this->request->getPost('ajax_country');

                if(!empty($country)){
                    $ElasticSearchModel = new ElasticSearchModel();
                    $states = $ElasticSearchModel->distinctStatesByCountry($country);
                } else {
                    $states = '';
                }
                echo json_encode($states);
                exit;
            }
        }
    }

    public function getCitiesAction(){

        if($this->request->isPost()){

            if($this->request->isAjax()) {

                $country = $this->request->getPost('ajax_country');
                $state = $this->request->getPost('ajax_state');

                if(!empty($country) && !empty($state)){
                    $ElasticSearchModel = new ElasticSearchModel();
                    $cities = $ElasticSearchModel->distinctCitiesByState($country, $state);
                } else {
                    $cities = '';
                }
                echo json_encode($cities);
                exit;
            }
        }
    }

    public function getProductsByCompanyIdAction(){
        if($this->request->isPost()){
            if($this->request->isAjax()) {
                $company_id = $this->request->getPost('ajax_company_id');
                if(!empty($company_id)){
                    $ElasticSearchModel = new ElasticSearchModel();
                    $plsa_s = $ElasticSearchModel->getProductsByCompanyId($company_id);
                } else {
                    $plsa_s = '';
                }
                echo json_encode($plsa_s);
                exit;
            }
        }
    }
    public function getProductsBySearchAction(){
        if($this->request->isPost()){
            if($this->request->isAjax()) {
                $company_id = $this->request->getPost('ajax_company_id');
                $search = $this->request->getPost('ajax_search');
                $ajax_more_plus_products = $this->request->getPost('ajax_more_plus_products');
                if($ajax_more_plus_products == ''){
                    $from = 0;
                }else{
                    $from = ((int)$ajax_more_plus_products - 1) * 100;
                }
                $size = 100;
                $data = array();
                $search = str_replace('?', '', $search);
                if (isset($search) && !empty($search)) {
                    $pairs = explode('&', $search);
                    foreach($pairs as $pair) {
                        $part = explode('=', $pair);
                        $data[$part[0]] = trim(urldecode($part[1]));
                    }
                }
                if(!empty($company_id)){
                    $ElasticSearchModel = new ElasticSearchModel();
                    $plsa_s = $ElasticSearchModel->getProductsForAjax($company_id, $data, $from, $size);
                } else {
                    $plsa_s = '';
                }
                echo json_encode($plsa_s);
                exit;
            }
        }
    }

    public function getName_pcckAction(){
        if($this->request->isPost()){
            if($this->request->isAjax()) {
                $find_name = array();
                $term = $this->request->getPost("term");
                if(!empty($term)){
                    $ElasticSearchModel = new ElasticSearchModel();
                    $result_search = $ElasticSearchModel->getProductsAndCompaniesByName($term, 0, 100);
                } else {
                    $result_search = '';

                }
                $f_all = false;
                foreach($result_search['plsa'] as $k=>$plsa){
                    if (strpos($plsa['_source']['product_name'],$term) !== false) {
                        $f_all = true;
                        $find_name_pl = $term . " in Product Lists";
                        $find_name[] = $plsa['_source']['product_name'];
                    }
                }
                $find_name = array_unique($find_name);
                foreach($result_search['companies'] as $k_c=>$company){
                    if (strpos($company['_source']['title'],$term) !== false) {
                        $f_all = true;
                        $find_name_co = $term . " in Companies";
                        $find_name[] = $company['_source']['title'];
                    }
                    if(!empty($company['_source']['tagline'])){
                        foreach($company['_source']['tagline'] as $t=>$tagline){
                            if (strpos($tagline,$term) !== false) {
                                $f_all = true;
                                $find_name_ca = $term . " in Categories";
                                $find_name[] = $tagline;
                            }
                        }
                    }
                    if(!empty($company['_source']['keywords'])){
                        foreach($company['_source']['keywords'] as $k=>$keyword){
                            if (strpos($keyword,$term) !== false) {
                                $f_all = true;
                                $find_name_k = $term . " in Keywords";
                                $find_name[] = $keyword;
                            }
                        }
                    }


                }
                $find_name = array_unique($find_name);
                array_multisort($find_name, SORT_ASC, SORT_STRING);
                if($f_all){
                    $find_name_all = $term . " (Searches the word " .$term ." in all of the above fields)";
                    array_unshift($find_name, $find_name_all);
                }
                if(isset($find_name_k)){array_unshift($find_name, $find_name_k);}
                if(isset($find_name_pl)){array_unshift($find_name, $find_name_pl);}
                if(isset($find_name_ca)){array_unshift($find_name, $find_name_ca);}
                if(isset($find_name_co)){array_unshift($find_name, $find_name_co);}


                echo json_encode($find_name);
                exit;
            }
        }
    }

    public function getProductsNameAdvancedSearchAction(){
        if($this->request->isPost()){
            if($this->request->isAjax()) {
                $find_name = array();
                $term = $this->request->getPost("term");

                $config = $this->getDI()->get('config');
                $client_products= new Elasticsearch\Client();
                $searchProductsParams['index'] = $config['elasticSearch']['products']['index'];
                $searchProductsParams['type']  = $config['elasticSearch']['products']['type'];
                $query_products["match"]["product_name"] = array(
                    "query"=>$term,
                    "operator" => "and"
                );
                $searchProductsParams["body"]["from"] = 0;
                $searchProductsParams["body"]["size"] = 100;
                $searchProductsParams["body"]["query"]["filtered"] = array(
                    "query"=>$query_products
                );
                $result_search_products = $client_products->search($searchProductsParams);

                //find plsa
                $result_search_products = $result_search_products["hits"]["hits"];
                $result_search['plsa'] = $result_search_products;

                foreach($result_search['plsa'] as $k=>$plsa){
                    if (strpos($plsa['_source']['product_name'],$term) !== false) {
//                        $find_name_pl = $term . " in Product Lists";
                        $find_name[] = $plsa['_source']['product_name'];
                    }
                }
                $find_name = array_unique($find_name);
                array_multisort($find_name, SORT_ASC, SORT_STRING);
//                if(isset($find_name_pl)){array_unshift($find_name, $find_name_pl);}

                echo json_encode($find_name);
                exit;
            }
        }
    }

    public function getLocationDataAction(){
        if($this->request->isPost()){
            if($this->request->isAjax()) {
                $location = array();
                $term = $this->request->getPost("term");
                if(!empty($term)){
                    $ElasticSearchModel = new ElasticSearchModel();
                    $result_search = $ElasticSearchModel->getLocationData($term, 0, 100);
                } else {
                    $result_search = '';

                }
                if(!empty($result_search['plsa'])){
                    foreach($result_search['plsa'] as $k=>$plsa){
                        if (strpos($plsa['_source']['sa_country'],$term) !== false) {
                            $location[] = $plsa['_source']['sa_country'];
                        }
                        if (strpos($plsa['_source']['sa_state'],$term) !== false) {
                            $location[] = $plsa['_source']['sa_state'];
                        }
                        if (strpos($plsa['_source']['sa_city'],$term) !== false) {
                            $location[] = $plsa['_source']['sa_city'];
                        }
                        if (strpos($plsa['_source']['sa_city'],$term) !== false) {
                            $location[] = $plsa['_source']['sa_city'];
                        }
                    }
                    $location = array_unique($location);
                }

                if(!empty($result_search['companies'])){
                    foreach($result_search['companies'] as $k=>$company){
                        if (strpos($company['_source']['country'],$term) !== false) {
                            $location[] = $company['_source']['country'];
                        }
                        if (strpos($company['_source']['state'],$term) !== false) {
                            $location[] = $company['_source']['state'];
                        }
                        if (strpos($company['_source']['city'],$term) !== false) {
                            $location[] = $company['_source']['city'];
                        }
                        if (strpos($company['_source']['postcode'],$term) !== false) {
                            $location[] = $company['_source']['postcode'];
                        }
                    }
                    $location = array_unique($location);
                }
                $location = array_unique($location);
                array_multisort($location, SORT_ASC, SORT_STRING);
                echo json_encode($location);
                exit;
            }
        }
    }
}
