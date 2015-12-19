<?php

namespace CoolBlueTest\Controllers;

use \Merkury\View;
use CoolBlueTest\Models\Address;

class IndexController extends \Merkury\Controller
{
    public function indexAction(){
    	$addressList = $this->getAllAddresses();

    	if($addressList == null)
    		return View::render('index/empty.html');

		return View::render('index/index.html', array('addressList' => $addressList));
    }

    public function getAddressAction($id){

        $addressId = $id;

        $addressList = $this->getAllAddresses();
        if($id > count($addressList) || $addressList == null)
            return View::render('index/index.html', array('error' => ' Register not found', 'errCode' => '404'));

        return View::render('index/index.html', array('addressList' => array($addressList[$id])));
    }

    public function addAddressAction(){

    	if($this->isMethodPost()){
            $address = new Address();
            $formValues = $this->_request->getPostParams();

            if($address->validateFormData($formValues) != true)
               return View::render('index/add-address.html', array('error' => ' Bad Post Data', 'errCode' => '400'));
            $address->setName($formValues['name']);
            $address->setPhone($formValues['phone']);
            $address->setStreet($formValues['street']);

            $res = $this->writeNewAddress($address);
            if($res)
                return View::render('index/add-address.html', array('success' => 'Contact added'));
            else
               return View::render('index/add-address.html', array('error' => ' Error writing the file', 'errCode' => '500'));
        }

    	return View::render('index/add-address.html');
    }

    public function editAddressAction($id){

        $address = $this->getAddressByLine($id);

        if(!$address)
            return View::render('index/index.html', array('error' => ' Register not found', 'errCode' => '404'));

        if($this->isMethodPost()){
            $formValues = $this->_request->getPostParams();

            if($address->validateFormData($formValues) != true)
               return View::render('index/add-address.html', array('error' => ' Bad Post Data', 'errCode' => '400'));
            $address->setName($formValues['name']);
            $address->setPhone($formValues['phone']);
            $address->setStreet($formValues['street']);
            $res = $this->updateAddress($address, $id);
            if($res)
                return View::render('index/index.html', array('success' => 'Contact '.$address->getName().' updated', 'addressList' => $this->getAllAddresses()));
            else
               return View::render('index/edit-address.html', array('error' => ' Error writing the file', 'errCode' => '500', 'address' => $address, 'id' => $id));
        }

        return View::render('index/edit-address.html', array('address' => $address, 'id' => $id));
    }

    public function removeAddressAction($id){

        $address = $this->getAddressByLine($id);

        if(!$address)
            return View::render('index/index.html', array('error' => ' Register not found', 'errCode' => '404'));

            $res = $this->updateAddress($address, $id, true);
            if($res)
                return View::render('index/index.html', array('success' => 'Contact '.$address->getName().' removed', 'addressList' => $this->getAllAddresses()));
            else
               return View::render('index/remove-address.html', array('error' => ' Error writing the file', 'errCode' => '500', 'address' => $address, 'id' => $id));
    }

    private function getAllAddresses(){
        $file = file_exists(APP_PATH.'/../public/uploads/addresses.csv') ? fopen(APP_PATH.'/../public/uploads/addresses.csv', 'r') : null;

        if(!$file)
            return null;

        $addressList = array();

        while (($line = fgetcsv($file)) !== FALSE) {
            $address = new Address();
            $address->setName($line[0]);
            $address->setPhone($line[1]);
            $address->setStreet($line[2]);
            array_push($addressList, $address);
        }
        fclose($file);

        return $addressList;
    }

    private function getAddressByLine($line){
        return array_key_exists($line, $this->getAllAddresses()) ? $this->getAllAddresses()[$line] : null;
    }


    /**TODO Move this functions to Model */
    private function writeNewAddress($address){
        $file = file_exists(APP_PATH.'/../public/uploads/addresses.csv') ? fopen(APP_PATH.'/../public/uploads/addresses.csv', 'a') : null;

        if(!$file)
            return null;

        $res = fputcsv($file,explode(',',$address->formatToSave()));
        fclose($file);

        return $res > 0 ? true : false;
    }

    private function updateAddress($newAddress, $pos, $remove = false){
        $addresses = $this->getAllAddresses();
        if($remove == false)
            $addresses[$pos] = $newAddress;
        else
            if(array_key_exists($pos, $addresses)) 
                unset($addresses[$pos]);
            else
                return false;

        $totalLines = count($addresses);
        $temp = fopen(APP_PATH.'/../public/uploads/tempUpdate.csv', 'a');

        //backup original file
        rename(APP_PATH.'/../public/uploads/addresses.csv', APP_PATH.'/../public/uploads/backup.csv');

        if(!$temp)
            return null;
        $writted = 0;
        foreach ($addresses as $address) {
            $tres = fputcsv($temp, explode(',', $address->formatToSave()));
            if($tres > 0)
                $writted++;
        }

        fclose($temp);
        rename(APP_PATH.'/../public/uploads/tempUpdate.csv', APP_PATH.'/../public/uploads/addresses.csv');

        if($totalLines != $writted && $remove == false ){
            rename(APP_PATH.'/../public/uploads/backup.csv', APP_PATH.'/../public/uploads/addresses.csv');
            return false;
        }

        if(file_exists(APP_PATH.'/../public/uploads/backup.csv'))
            unlink(APP_PATH.'/../public/uploads/backup.csv');

        return true;
    }

}
