<?php

class Stripe_Subscription extends Stripe_ApiResource
{
  /**
   * @return string The API URL for this Stripe subscription.
   */
  public function instanceUrl()
  {
    $id = $this['id'];
    $customer = $this['customer'];
    $class = get_class($this);
    if (!$id) {
      throw new Stripe_InvalidRequestError(
          "Could not determine which URL to request: " .
          "class instance has invalid ID: $id",
          null
      );
    }
    $id = Stripe_ApiRequestor::utf8($id);
    $customer = Stripe_ApiRequestor::utf8($customer);

    $base = self::classUrl('Stripe_Customer');
    $customerExtn = urlencode($customer);
    $extn = urlencode($id);
    return "$base/$customerExtn/subscriptions/$extn";
  }

  /**
   * @param array|null $params
   * @return Stripe_Subscription The deleted subscription.
   */
  public static function cancel($params=null)
  {
    $class = get_class();
    return self::_scopedDelete($class, $params);
  }

  /**
   * @return Stripe_Subscription The saved subscription.
   */
  public static function save()
  {
    $class = get_class();
    return self::_scopedSave($class);
  }

  /**
   * @return Stripe_Subscription The updated subscription.
   */
  public function deleteDiscount()
  {
    $requestor = new Stripe_ApiRequestor($this->_apiKey);
    $url = $this->instanceUrl() . '/discount';
    list($response, $apiKey) = $requestor->request('delete', $url);
    $this->refreshFrom(array('discount' => null), $apiKey, true);
  }
  
  
  
  
  
  
  
  // adding functions 
  public static function retrieve($id, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedRetrieve($class, $id, $apiKey);
  }
  
  public static function create($params=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedCreate($class, $params, $apiKey);
  }
  
  public function delete($params=null)
  {
    $class = get_class();
    return self::_scopedDelete($class, $params);
  }
  
}
