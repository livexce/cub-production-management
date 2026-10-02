<?php

session_start();

require_once('db.php');
require_once('tools.php');

switch ($_GET['function']) {
    case 'addItemElement':
        db::addItemElement($_GET['id_item'], $_GET['id_element'], $_GET['value']);
        break;
    case 'updateShippingComment':
        db::updateShippingComment($_GET['id_order'], $_GET['shipping_comment']);
        break;
    case 'addParamTeintType':
        db::addParamTeintType($_GET['value']);
        break;
    case 'deleteParamTeintType':
        db::deleteParamTeintType($_GET['id']);
        break;
    case 'generateElementsForFabForm':
        db::generateElementsForFabForm($_GET['id_fab_form']);
        break;
//    case 'addParamPrepa':
//        db::addParamPrepa($_GET['value']);
//        break;
//    case 'deleteParamPrepa':
//        db::deleteParamPrepa($_GET['id']);
//        break;
//    case 'addParamTeintCode':
//        db::addParamTeintCode($_GET['value']);
//        break;
//    case 'deleteParamTeintCode':
//        db::deleteParamTeintCode($_GET['id']);
//        break;
//    case 'addParamTeintText1':
//        db::addParamTeintText1($_GET['value']);
//        break;
//    case 'deleteParamTeintText1':
//        db::deleteParamTeintText1($_GET['id']);
//        break;
//    case 'addParamTeintText2':
//        db::addParamTeintText2($_GET['value']);
//        break;
//    case 'deleteParamTeintText2':
//        db::deleteParamTeintText2($_GET['id']);
//        break;
//    case 'addParamEmbal':
//        db::addParamEmbal($_GET['value']);
//        break;
//    case 'deleteParamEmbal':
//        db::deleteParamEmbal($_GET['id']);
//        break;

    case 'addElement':
        db::addElement($_GET['name']);
        break;
    case 'deleteElement':
        db::deleteElement($_GET['id']);
        break;
    case 'closeTicket':
        db::closeTicket($_GET['id_ticket']);
        break;
    case 'updateReceptionCustomer':
        db::updateReceptionCustomer($_GET['id_reception'], $_GET['id_customer']);
        break;
    case 'updateReceptionComment':
        db::updateReceptionComment($_GET['id_reception'], $_GET['comment']);
        break;
    case 'validateReception':
        db::validateReception($_GET['id_reception']);
        break;
    case 'receiptFabfom':
        $currentfabForm = db::getFabForm($_GET['id_fab_form']);
        db::updateFieldfabForm($_GET['id_fab_form'], 'status', 'A préparer', 'varchar', $currentfabForm['status']);
        db::addReceptionReceipt($_GET['id_reception'], $_GET['id_fab_form']);
        break;
}
  
