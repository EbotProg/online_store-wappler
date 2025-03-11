<?php

namespace modules;

if (file_exists(__DIR__ . '/../stripe/init.php')) {
  require_once(__DIR__ . '/../stripe/init.php');
}

use \lib\core\Module;

class stripe extends Module
{
  public $stripe;

  function __construct($app) {
    $this->stripe = new \Stripe\StripeClient(CONFIG('STRIPE_SECRET_KEY'));
    parent::__construct($app);
  }

  // /v1/account_links - post
  public function createAccountLink($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->refresh_url) && !strpos($options->refresh_url, '://')) {
      $options->refresh_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->refresh_url;
    }
    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    return $this->stripe->accountLinks->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/account_sessions - post
  public function createAccountSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->accountSessions->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts - get
  public function listAccounts($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->accounts->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts - post
  public function createAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->accounts->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account} - delete
  public function deleteAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->delete($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account} - get
  public function retrieveAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->retrieve($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account} - post
  public function updateAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->update($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/capabilities - get
  public function listAccountCapabilities($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->listCapabilities($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/capabilities/{capability} - get
  public function retrieveAccountCapabilitie($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    option_require($options, 'capability');
    $capability = $options->capability;
    unset($options->capability);
    return $this->stripe->accounts->retrieveCapabilitie($account, $capability, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/capabilities/{capability} - post
  public function updateAccountCapabilitie($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    option_require($options, 'capability');
    $capability = $options->capability;
    unset($options->capability);
    return $this->stripe->accounts->updateCapabilitie($account, $capability, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/external_accounts - get
  public function listAccountExternalAccounts($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->listExternalAccounts($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/external_accounts - post
  public function createAccountExternalAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->createExternalAccount($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/external_accounts/{id} - delete
  public function deleteAccountExternalAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->accounts->deleteExternalAccount($account, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/external_accounts/{id} - get
  public function retrieveAccountExternalAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->accounts->retrieveExternalAccount($account, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/external_accounts/{id} - post
  public function updateAccountExternalAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->accounts->updateExternalAccount($account, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/login_links - post
  public function createAccountLoginLink($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->createLoginLink($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/persons - get
  public function listAccountPersons($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->listPersons($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/persons - post
  public function createAccountPerson($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->createPerson($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/persons/{person} - delete
  public function deleteAccountPerson($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    option_require($options, 'person');
    $person = $options->person;
    unset($options->person);
    return $this->stripe->accounts->deletePerson($account, $person, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/persons/{person} - get
  public function retrieveAccountPerson($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    option_require($options, 'person');
    $person = $options->person;
    unset($options->person);
    return $this->stripe->accounts->retrievePerson($account, $person, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/persons/{person} - post
  public function updateAccountPerson($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    option_require($options, 'person');
    $person = $options->person;
    unset($options->person);
    return $this->stripe->accounts->updatePerson($account, $person, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/accounts/{account}/reject - post
  public function rejectAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->accounts->reject($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/apple_pay/domains - get
  public function listApplePayDomains($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->applePay->domains->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/apple_pay/domains - post
  public function createApplePayDomain($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->applePay->domains->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/apple_pay/domains/{domain} - delete
  public function deleteApplePayDomain($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'domain');
    $domain = $options->domain;
    unset($options->domain);
    return $this->stripe->applePay->domains->delete($domain, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/apple_pay/domains/{domain} - get
  public function retrieveApplePayDomain($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'domain');
    $domain = $options->domain;
    unset($options->domain);
    return $this->stripe->applePay->domains->retrieve($domain, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/application_fees - get
  public function listApplicationFees($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->applicationFees->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/application_fees/{fee}/refunds/{id} - get
  public function retrieveApplicationFeeRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'fee');
    $fee = $options->fee;
    unset($options->fee);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->applicationFees->retrieveRefund($fee, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/application_fees/{fee}/refunds/{id} - post
  public function updateApplicationFeeRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'fee');
    $fee = $options->fee;
    unset($options->fee);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->applicationFees->updateRefund($fee, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/application_fees/{id} - get
  public function retrieveApplicationFee($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->applicationFees->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/application_fees/{id}/refunds - get
  public function listApplicationFeeRefunds($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->applicationFees->listRefunds($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/application_fees/{id}/refunds - post
  public function createApplicationFeeRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->applicationFees->createRefund($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/apps/secrets - get
  public function listAppsSecrets($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'scope');
    return $this->stripe->apps->secrets->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/apps/secrets - post
  public function createAppsSecret($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->apps->secrets->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/apps/secrets/delete - post
  public function createAppsSecretsDelete($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->apps->secrets->delete->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/apps/secrets/find - get
  public function retrieveAppsSecretsFind($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'name');
    option_require($options, 'scope');
    return $this->stripe->apps->secrets->find->retrieve(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/balance - get
  public function retrieveBalance($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->balance->retrieve(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/balance_transactions - get
  public function listBalanceTransactions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->balanceTransactions->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/balance_transactions/{id} - get
  public function retrieveBalanceTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->balanceTransactions->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing/meter_event_adjustments - post
  public function createBillingMeterEventAdjustment($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->billing->meterEventAdjustments->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing/meter_events - post
  public function createBillingMeterEvent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->billing->meterEvents->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing/meters - get
  public function listBillingMeters($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->billing->meters->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing/meters - post
  public function createBillingMeter($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->billing->meters->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing/meters/{id} - get
  public function retrieveBillingMeter($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->billing->meters->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing/meters/{id} - post
  public function updateBillingMeter($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->billing->meters->update($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing/meters/{id}/deactivate - post
  public function deactivateBillingMeter($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->billing->meters->deactivate($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing/meters/{id}/event_summaries - get
  public function listBillingMeterEventSummaries($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    option_require($options, 'end_time');
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    option_require($options, 'start_time');
    return $this->stripe->billing->meters->listEventSummaries($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing/meters/{id}/reactivate - post
  public function reactivateBillingMeter($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->billing->meters->reactivate($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing_portal/configurations - get
  public function listBillingPortalConfigurations($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->billingPortal->configurations->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing_portal/configurations - post
  public function createBillingPortalConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->default_return_url) && !strpos($options->default_return_url, '://')) {
      $options->default_return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->default_return_url;
    }
    return $this->stripe->billingPortal->configurations->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing_portal/configurations/{configuration} - get
  public function retrieveBillingPortalConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'configuration');
    $configuration = $options->configuration;
    unset($options->configuration);
    return $this->stripe->billingPortal->configurations->retrieve($configuration, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing_portal/configurations/{configuration} - post
  public function updateBillingPortalConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'configuration');
    $configuration = $options->configuration;
    unset($options->configuration);
    if (isset($options->default_return_url) && !strpos($options->default_return_url, '://')) {
      $options->default_return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->default_return_url;
    }
    return $this->stripe->billingPortal->configurations->update($configuration, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/billing_portal/sessions - post
  public function createBillingPortalSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    return $this->stripe->billingPortal->sessions->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/charges - get
  public function listCharges($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->charges->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/charges - post
  public function createCharge($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->charges->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/charges/search - get
  public function searchCharges($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'query');
    return $this->stripe->charges->search(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/charges/{charge} - get
  public function retrieveCharge($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'charge');
    $charge = $options->charge;
    unset($options->charge);
    return $this->stripe->charges->retrieve($charge, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/charges/{charge} - post
  public function updateCharge($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'charge');
    $charge = $options->charge;
    unset($options->charge);
    return $this->stripe->charges->update($charge, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/charges/{charge}/capture - post
  public function captureCharge($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'charge');
    $charge = $options->charge;
    unset($options->charge);
    return $this->stripe->charges->capture($charge, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/charges/{charge}/refunds - get
  public function listChargeRefunds($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'charge');
    $charge = $options->charge;
    unset($options->charge);
    return $this->stripe->charges->listRefunds($charge, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/charges/{charge}/refunds/{refund} - get
  public function retrieveChargeRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'charge');
    $charge = $options->charge;
    unset($options->charge);
    option_require($options, 'refund');
    $refund = $options->refund;
    unset($options->refund);
    return $this->stripe->charges->retrieveRefund($charge, $refund, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/checkout/sessions - get
  public function listCheckoutSessions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->checkout->sessions->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/checkout/sessions - post
  public function createCheckoutSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->cancel_url) && !strpos($options->cancel_url, '://')) {
      $options->cancel_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->cancel_url;
    }
    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    if (isset($options->success_url) && !strpos($options->success_url, '://')) {
      $options->success_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->success_url;
    }
    if ($options && isset($options->lineItemsType)) {
      if ($options->lineItemsType == 'customList' || $options->lineItemsType == 'customRef') {
        if (isset($options->line_items)) {
          $options->line_items = json_decode(json_encode($options->line_items));
          if (!is_array($options->line_items)) {
            if (is_object($options->line_items)) {
              $options->line_items = array($options->line_items);
            } else {
              throw new \Exception('createCheckoutSession: line_items must be array or object for references!');
            }
          } else if (empty($options->line_items)) {
            throw new \Exception('createCheckoutSession: line_items is empty!');
          }
        } else {
          throw new \Exception('createCheckoutSession: line_items is not set!');
        }

        $options->line_items = array_map(function($item) {
          $item = (object)$item;
          $output = (object)array();
          $output->price_data = (object)array();
          $output->price_data->currency = isset($item->currency) ? $item->currency : 'USD';
          $output->price_data->product_data = (object)array();
          $output->price_data->product_data->name = $item->title;
          $output->price_data->unit_amount_decimal = $item->amount;
          $output->quantity = isset($item->quantity) ? $item->quantity : 1;
          return $output;
        }, $options->line_items);
      }
      unset($options->lineItemsType);
    } else {
      if (isset($options->line_items)) {
        $options->line_items = json_decode(json_encode($options->line_items));
        if (is_array($options->line_items)) {
          if (empty($options->line_items)) {
            throw new \Exception('createCheckoutSession: line_items is empty!');
          }
          $options->line_items = array_map(function($item) {
            $item = (object)$item;
            $output = (object)array();
            $output->price = $item->price;
            $output->quantity = isset($item->quantity) ? $item->quantity : 1;
            return $output;
          }, $options->line_items);
        } else if (is_object($options->line_items)) {
          $options->line_items = array($options->line_items);
        } else if (is_string($options->line_items)) {
          $output = (object)array();
          $output->price = $options->line_items;
          $output->quantity = 1;
          $options->line_items = array($output);
        }
      }
    }

    return $this->stripe->checkout->sessions->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/checkout/sessions/{session} - get
  public function retrieveCheckoutSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'session');
    $session = $options->session;
    unset($options->session);
    return $this->stripe->checkout->sessions->retrieve($session, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/checkout/sessions/{session}/expire - post
  public function expireCheckoutSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'session');
    $session = $options->session;
    unset($options->session);
    return $this->stripe->checkout->sessions->expire($session, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/checkout/sessions/{session}/line_items - get
  public function listCheckoutSessionLineItems($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'session');
    $session = $options->session;
    unset($options->session);
    return $this->stripe->checkout->sessions->listLineItems($session, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/climate/orders - get
  public function listClimateOrders($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->climate->orders->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/climate/orders - post
  public function createClimateOrder($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->climate->orders->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/climate/orders/{order} - get
  public function retrieveClimateOrder($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'order');
    $order = $options->order;
    unset($options->order);
    return $this->stripe->climate->orders->retrieve($order, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/climate/orders/{order} - post
  public function updateClimateOrder($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'order');
    $order = $options->order;
    unset($options->order);
    return $this->stripe->climate->orders->update($order, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/climate/orders/{order}/cancel - post
  public function cancelClimateOrder($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'order');
    $order = $options->order;
    unset($options->order);
    return $this->stripe->climate->orders->cancel($order, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/climate/products - get
  public function listClimateProducts($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->climate->products->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/climate/products/{product} - get
  public function retrieveClimateProduct($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'product');
    $product = $options->product;
    unset($options->product);
    return $this->stripe->climate->products->retrieve($product, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/climate/suppliers - get
  public function listClimateSuppliers($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->climate->suppliers->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/climate/suppliers/{supplier} - get
  public function retrieveClimateSupplier($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'supplier');
    $supplier = $options->supplier;
    unset($options->supplier);
    return $this->stripe->climate->suppliers->retrieve($supplier, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/confirmation_tokens/{confirmation_token} - get
  public function retrieveConfirmationToken($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'confirmation_token');
    $confirmation_token = $options->confirmation_token;
    unset($options->confirmation_token);
    return $this->stripe->confirmationTokens->retrieve($confirmation_token, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/country_specs - get
  public function listCountrySpecs($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->countrySpecs->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/country_specs/{country} - get
  public function retrieveCountrySpec($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'country');
    $country = $options->country;
    unset($options->country);
    return $this->stripe->countrySpecs->retrieve($country, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/coupons - get
  public function listCoupons($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->coupons->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/coupons - post
  public function createCoupon($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->coupons->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/coupons/{coupon} - delete
  public function deleteCoupon($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'coupon');
    $coupon = $options->coupon;
    unset($options->coupon);
    return $this->stripe->coupons->delete($coupon, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/coupons/{coupon} - get
  public function retrieveCoupon($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'coupon');
    $coupon = $options->coupon;
    unset($options->coupon);
    return $this->stripe->coupons->retrieve($coupon, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/coupons/{coupon} - post
  public function updateCoupon($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'coupon');
    $coupon = $options->coupon;
    unset($options->coupon);
    return $this->stripe->coupons->update($coupon, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/credit_notes - get
  public function listCreditNotes($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->creditNotes->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/credit_notes - post
  public function createCreditNote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->creditNotes->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/credit_notes/preview - get
  public function retrieveCreditNotesPreview($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    return $this->stripe->creditNotes->preview(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/credit_notes/preview/lines - get
  public function listCreditNotesPreviewLines($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    return $this->stripe->creditNotes->allCreditNoteLineItems(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/credit_notes/{credit_note}/lines - get
  public function listCreditNoteLines($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'credit_note');
    $credit_note = $options->credit_note;
    unset($options->credit_note);
    return $this->stripe->creditNotes->listLines($credit_note, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/credit_notes/{id} - get
  public function retrieveCreditNote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->creditNotes->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/credit_notes/{id} - post
  public function updateCreditNote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->creditNotes->update($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/credit_notes/{id}/void - post
  public function voidCreditNote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->creditNotes->void($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customer_sessions - post
  public function createCustomerSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->customerSessions->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers - get
  public function listCustomers($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->customers->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers - post
  public function createCustomer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->customers->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/search - get
  public function searchCustomers($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'query');
    return $this->stripe->customers->search(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer} - delete
  public function deleteCustomer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->delete($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer} - get
  public function retrieveCustomer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->retrieve($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer} - post
  public function updateCustomer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->update($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/balance_transactions - get
  public function listCustomerBalanceTransactions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->listBalanceTransactions($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/balance_transactions - post
  public function createCustomerBalanceTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->createBalanceTransaction($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/balance_transactions/{transaction} - get
  public function retrieveCustomerBalanceTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    option_require($options, 'transaction');
    $transaction = $options->transaction;
    unset($options->transaction);
    return $this->stripe->customers->retrieveBalanceTransaction($customer, $transaction, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/balance_transactions/{transaction} - post
  public function updateCustomerBalanceTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    option_require($options, 'transaction');
    $transaction = $options->transaction;
    unset($options->transaction);
    return $this->stripe->customers->updateBalanceTransaction($customer, $transaction, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/cash_balance - get
  public function retrieveCustomerCashBalance($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->retrieveCashBalance($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/cash_balance - post
  public function cashBalanceCustomer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->cashBalance($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/cash_balance_transactions - get
  public function listCustomerCashBalanceTransactions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->listCashBalanceTransactions($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/cash_balance_transactions/{transaction} - get
  public function retrieveCustomerCashBalanceTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    option_require($options, 'transaction');
    $transaction = $options->transaction;
    unset($options->transaction);
    return $this->stripe->customers->retrieveCashBalanceTransaction($customer, $transaction, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/discount - delete
  public function deleteCustomerDiscount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->deleteDiscount($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/funding_instructions - post
  public function createCustomerFundingInstruction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->createFundingInstruction($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/payment_methods - get
  public function listCustomerPaymentMethods($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->listPaymentMethods($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/payment_methods/{payment_method} - get
  public function retrieveCustomerPaymentMethod($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    option_require($options, 'payment_method');
    $payment_method = $options->payment_method;
    unset($options->payment_method);
    return $this->stripe->customers->retrievePaymentMethod($customer, $payment_method, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/sources - get
  public function listCustomerSources($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->listSources($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/sources - post
  public function createCustomerSource($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->createSource($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/sources/{id} - delete
  public function deleteCustomerSource($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->customers->deleteSource($customer, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/sources/{id} - get
  public function retrieveCustomerSource($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->customers->retrieveSource($customer, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/sources/{id} - post
  public function updateCustomerSource($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->customers->updateSource($customer, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/tax_ids - get
  public function listCustomerTaxIds($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->listTaxIds($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/tax_ids - post
  public function createCustomerTaxId($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->customers->createTaxId($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/tax_ids/{id} - delete
  public function deleteCustomerTaxId($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->customers->deleteTaxId($customer, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/customers/{customer}/tax_ids/{id} - get
  public function retrieveCustomerTaxId($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->customers->retrieveTaxId($customer, $id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/disputes - get
  public function listDisputes($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->disputes->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/disputes/{dispute} - get
  public function retrieveDispute($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'dispute');
    $dispute = $options->dispute;
    unset($options->dispute);
    return $this->stripe->disputes->retrieve($dispute, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/disputes/{dispute} - post
  public function updateDispute($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'dispute');
    $dispute = $options->dispute;
    unset($options->dispute);
    return $this->stripe->disputes->update($dispute, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/disputes/{dispute}/close - post
  public function closeDispute($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'dispute');
    $dispute = $options->dispute;
    unset($options->dispute);
    return $this->stripe->disputes->close($dispute, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/ephemeral_keys - post
  public function createEphemeralKey($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->ephemeralKeys->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/ephemeral_keys/{key} - delete
  public function deleteEphemeralKey($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'key');
    $key = $options->key;
    unset($options->key);
    return $this->stripe->ephemeralKeys->delete($key, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/events - get
  public function listEvents($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->events->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/events/{id} - get
  public function retrieveEvent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->events->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/exchange_rates - get
  public function listExchangeRates($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->exchangeRates->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/exchange_rates/{rate_id} - get
  public function retrieveExchangeRate($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'rate_id');
    $rate_id = $options->rate_id;
    unset($options->rate_id);
    return $this->stripe->exchangeRates->retrieve($rate_id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/file_links - get
  public function listFileLinks($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->fileLinks->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/file_links - post
  public function createFileLink($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->fileLinks->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/file_links/{link} - get
  public function retrieveFileLink($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'link');
    $link = $options->link;
    unset($options->link);
    return $this->stripe->fileLinks->retrieve($link, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/file_links/{link} - post
  public function updateFileLink($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'link');
    $link = $options->link;
    unset($options->link);
    return $this->stripe->fileLinks->update($link, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/files - get
  public function listFiles($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->files->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/files - post
  public function createFile($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->filePath)) {
      if (file_exists($options->filePath)) {
        $fp = file_get_contents($options->filePath);
        $options->file = $fp;
      } else {
        throw new \Exception('createFile: File not found: ' . $options->filePath);
      }
      unset($options->filePath);
    } else {
      throw new \Exception('createFile: filePath is required!');
    }

    return $this->stripe->files->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/files/{file} - get
  public function retrieveFile($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'file');
    $file = $options->file;
    unset($options->file);
    return $this->stripe->files->retrieve($file, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/accounts - get
  public function listFinancialConnectionsAccounts($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->financialConnections->accounts->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/accounts/{account} - get
  public function retrieveFinancialConnectionsAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->financialConnections->accounts->retrieve($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/accounts/{account}/disconnect - post
  public function disconnectFinancialConnectionsAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->financialConnections->accounts->disconnect($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/accounts/{account}/owners - get
  public function listFinancialConnectionsAccountOwners($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    option_require($options, 'ownership');
    return $this->stripe->financialConnections->accounts->listOwners($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/accounts/{account}/refresh - post
  public function refreshFinancialConnectionsAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->financialConnections->accounts->refresh($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/accounts/{account}/subscribe - post
  public function subscribeFinancialConnectionsAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->financialConnections->accounts->subscribe($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/accounts/{account}/unsubscribe - post
  public function unsubscribeFinancialConnectionsAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    $account = $options->account;
    unset($options->account);
    return $this->stripe->financialConnections->accounts->unsubscribe($account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/sessions - post
  public function createFinancialConnectionsSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    return $this->stripe->financialConnections->sessions->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/sessions/{session} - get
  public function retrieveFinancialConnectionsSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'session');
    $session = $options->session;
    unset($options->session);
    return $this->stripe->financialConnections->sessions->retrieve($session, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/transactions - get
  public function listFinancialConnectionsTransactions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'account');
    return $this->stripe->financialConnections->transactions->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/financial_connections/transactions/{transaction} - get
  public function retrieveFinancialConnectionsTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'transaction');
    $transaction = $options->transaction;
    unset($options->transaction);
    return $this->stripe->financialConnections->transactions->retrieve($transaction, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/forwarding/requests - get
  public function listForwardingRequests($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->forwarding->requests->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/forwarding/requests - post
  public function createForwardingRequest($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->forwarding->requests->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/forwarding/requests/{id} - get
  public function retrieveForwardingRequest($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->forwarding->requests->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/identity/verification_reports - get
  public function listIdentityVerificationReports($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->identity->verificationReports->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/identity/verification_reports/{report} - get
  public function retrieveIdentityVerificationReport($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'report');
    $report = $options->report;
    unset($options->report);
    return $this->stripe->identity->verificationReports->retrieve($report, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/identity/verification_sessions - get
  public function listIdentityVerificationSessions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->identity->verificationSessions->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/identity/verification_sessions - post
  public function createIdentityVerificationSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    return $this->stripe->identity->verificationSessions->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/identity/verification_sessions/{session} - get
  public function retrieveIdentityVerificationSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'session');
    $session = $options->session;
    unset($options->session);
    return $this->stripe->identity->verificationSessions->retrieve($session, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/identity/verification_sessions/{session} - post
  public function updateIdentityVerificationSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'session');
    $session = $options->session;
    unset($options->session);
    return $this->stripe->identity->verificationSessions->update($session, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/identity/verification_sessions/{session}/cancel - post
  public function cancelIdentityVerificationSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'session');
    $session = $options->session;
    unset($options->session);
    return $this->stripe->identity->verificationSessions->cancel($session, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/identity/verification_sessions/{session}/redact - post
  public function redactIdentityVerificationSession($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'session');
    $session = $options->session;
    unset($options->session);
    return $this->stripe->identity->verificationSessions->redact($session, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoiceitems - get
  public function listInvoiceItems($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->invoiceItems->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoiceitems - post
  public function createInvoiceItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->invoiceItems->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoiceitems/{invoiceitem} - delete
  public function deleteInvoiceItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoiceitem');
    $invoiceitem = $options->invoiceitem;
    unset($options->invoiceitem);
    return $this->stripe->invoiceItems->delete($invoiceitem, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoiceitems/{invoiceitem} - get
  public function retrieveInvoiceItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoiceitem');
    $invoiceitem = $options->invoiceitem;
    unset($options->invoiceitem);
    return $this->stripe->invoiceItems->retrieve($invoiceitem, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoiceitems/{invoiceitem} - post
  public function updateInvoiceItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoiceitem');
    $invoiceitem = $options->invoiceitem;
    unset($options->invoiceitem);
    return $this->stripe->invoiceItems->update($invoiceitem, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices - get
  public function listInvoices($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->invoices->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices - post
  public function createInvoice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->invoices->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/search - get
  public function searchInvoices($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'query');
    return $this->stripe->invoices->search(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/upcoming - get
  public function retrieveInvoicesUpcoming($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->invoices->upcoming(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/upcoming/lines - get
  public function listInvoicesUpcomingLines($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->invoices->upcomingLines(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice} - delete
  public function deleteInvoice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    return $this->stripe->invoices->delete($invoice, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice} - get
  public function retrieveInvoice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    return $this->stripe->invoices->retrieve($invoice, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice} - post
  public function updateInvoice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    return $this->stripe->invoices->update($invoice, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice}/finalize - post
  public function finalizeInvoice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    return $this->stripe->invoices->finalize($invoice, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice}/lines - get
  public function listInvoiceLines($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    return $this->stripe->invoices->listLines($invoice, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice}/lines/{line_item_id} - post
  public function updateInvoiceLine($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    option_require($options, 'line_item_id');
    $line_item_id = $options->line_item_id;
    unset($options->line_item_id);
    return $this->stripe->invoices->updateLine($invoice, $line_item_id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice}/mark_uncollectible - post
  public function markUncollectibleInvoice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    return $this->stripe->invoices->markUncollectible($invoice, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice}/pay - post
  public function payInvoice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    return $this->stripe->invoices->pay($invoice, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice}/send - post
  public function sendInvoice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    return $this->stripe->invoices->send($invoice, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/invoices/{invoice}/void - post
  public function voidInvoice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'invoice');
    $invoice = $options->invoice;
    unset($options->invoice);
    return $this->stripe->invoices->void($invoice, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/authorizations - get
  public function listIssuingAuthorizations($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->authorizations->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/authorizations/{authorization} - get
  public function retrieveIssuingAuthorization($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'authorization');
    $authorization = $options->authorization;
    unset($options->authorization);
    return $this->stripe->issuing->authorizations->retrieve($authorization, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/authorizations/{authorization} - post
  public function updateIssuingAuthorization($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'authorization');
    $authorization = $options->authorization;
    unset($options->authorization);
    return $this->stripe->issuing->authorizations->update($authorization, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/authorizations/{authorization}/approve - post
  public function approveIssuingAuthorization($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'authorization');
    $authorization = $options->authorization;
    unset($options->authorization);
    return $this->stripe->issuing->authorizations->approve($authorization, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/authorizations/{authorization}/decline - post
  public function declineIssuingAuthorization($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'authorization');
    $authorization = $options->authorization;
    unset($options->authorization);
    return $this->stripe->issuing->authorizations->decline($authorization, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/cardholders - get
  public function listIssuingCardholders($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->cardholders->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/cardholders - post
  public function createIssuingCardholder($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->cardholders->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/cardholders/{cardholder} - get
  public function retrieveIssuingCardholder($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'cardholder');
    $cardholder = $options->cardholder;
    unset($options->cardholder);
    return $this->stripe->issuing->cardholders->retrieve($cardholder, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/cardholders/{cardholder} - post
  public function updateIssuingCardholder($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'cardholder');
    $cardholder = $options->cardholder;
    unset($options->cardholder);
    return $this->stripe->issuing->cardholders->update($cardholder, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/cards - get
  public function listIssuingCards($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->cards->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/cards - post
  public function createIssuingCard($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->cards->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/cards/{card} - get
  public function retrieveIssuingCard($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'card');
    $card = $options->card;
    unset($options->card);
    return $this->stripe->issuing->cards->retrieve($card, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/cards/{card} - post
  public function updateIssuingCard($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'card');
    $card = $options->card;
    unset($options->card);
    return $this->stripe->issuing->cards->update($card, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/disputes - get
  public function listIssuingDisputes($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->disputes->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/disputes - post
  public function createIssuingDispute($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->disputes->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/disputes/{dispute} - get
  public function retrieveIssuingDispute($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'dispute');
    $dispute = $options->dispute;
    unset($options->dispute);
    return $this->stripe->issuing->disputes->retrieve($dispute, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/disputes/{dispute} - post
  public function updateIssuingDispute($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'dispute');
    $dispute = $options->dispute;
    unset($options->dispute);
    return $this->stripe->issuing->disputes->update($dispute, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/disputes/{dispute}/submit - post
  public function submitIssuingDispute($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'dispute');
    $dispute = $options->dispute;
    unset($options->dispute);
    return $this->stripe->issuing->disputes->submit($dispute, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/personalization_designs - get
  public function listIssuingPersonalizationDesigns($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->personalizationDesigns->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/personalization_designs - post
  public function createIssuingPersonalizationDesign($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->personalizationDesigns->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/personalization_designs/{personalization_design} - get
  public function retrieveIssuingPersonalizationDesign($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'personalization_design');
    $personalization_design = $options->personalization_design;
    unset($options->personalization_design);
    return $this->stripe->issuing->personalizationDesigns->retrieve($personalization_design, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/personalization_designs/{personalization_design} - post
  public function updateIssuingPersonalizationDesign($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'personalization_design');
    $personalization_design = $options->personalization_design;
    unset($options->personalization_design);
    return $this->stripe->issuing->personalizationDesigns->update($personalization_design, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/physical_bundles - get
  public function listIssuingPhysicalBundles($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->physicalBundles->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/physical_bundles/{physical_bundle} - get
  public function retrieveIssuingPhysicalBundle($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'physical_bundle');
    $physical_bundle = $options->physical_bundle;
    unset($options->physical_bundle);
    return $this->stripe->issuing->physicalBundles->retrieve($physical_bundle, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/tokens - get
  public function listIssuingTokens($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'card');
    return $this->stripe->issuing->tokens->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/tokens/{token} - get
  public function retrieveIssuingToken($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'token');
    $token = $options->token;
    unset($options->token);
    return $this->stripe->issuing->tokens->retrieve($token, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/tokens/{token} - post
  public function updateIssuingToken($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'token');
    $token = $options->token;
    unset($options->token);
    return $this->stripe->issuing->tokens->update($token, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/transactions - get
  public function listIssuingTransactions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->issuing->transactions->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/transactions/{transaction} - get
  public function retrieveIssuingTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'transaction');
    $transaction = $options->transaction;
    unset($options->transaction);
    return $this->stripe->issuing->transactions->retrieve($transaction, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/issuing/transactions/{transaction} - post
  public function updateIssuingTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'transaction');
    $transaction = $options->transaction;
    unset($options->transaction);
    return $this->stripe->issuing->transactions->update($transaction, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/mandates/{mandate} - get
  public function retrieveMandate($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'mandate');
    $mandate = $options->mandate;
    unset($options->mandate);
    return $this->stripe->mandates->retrieve($mandate, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents - get
  public function listPaymentIntents($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->paymentIntents->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents - post
  public function createPaymentIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    return $this->stripe->paymentIntents->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents/search - get
  public function searchPaymentIntents($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'query');
    return $this->stripe->paymentIntents->search(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents/{intent} - get
  public function retrievePaymentIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->paymentIntents->retrieve($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents/{intent} - post
  public function updatePaymentIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->paymentIntents->update($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents/{intent}/apply_customer_balance - post
  public function applyCustomerBalancePaymentIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->paymentIntents->applyCustomerBalance($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents/{intent}/cancel - post
  public function cancelPaymentIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->paymentIntents->cancel($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents/{intent}/capture - post
  public function capturePaymentIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->paymentIntents->capture($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents/{intent}/confirm - post
  public function confirmPaymentIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    return $this->stripe->paymentIntents->confirm($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents/{intent}/increment_authorization - post
  public function incrementAuthorizationPaymentIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->paymentIntents->incrementAuthorization($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_intents/{intent}/verify_microdeposits - post
  public function createPaymentIntentVerifyMicrodeposit($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->paymentIntents->createVerifyMicrodeposit($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_links - get
  public function listPaymentLinks($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->paymentLinks->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_links - post
  public function createPaymentLink($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->paymentLinks->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_links/{payment_link} - get
  public function retrievePaymentLink($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_link');
    $payment_link = $options->payment_link;
    unset($options->payment_link);
    return $this->stripe->paymentLinks->retrieve($payment_link, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_links/{payment_link} - post
  public function updatePaymentLink($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_link');
    $payment_link = $options->payment_link;
    unset($options->payment_link);
    return $this->stripe->paymentLinks->update($payment_link, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_links/{payment_link}/line_items - get
  public function listPaymentLinkLineItems($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_link');
    $payment_link = $options->payment_link;
    unset($options->payment_link);
    return $this->stripe->paymentLinks->listLineItems($payment_link, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_method_configurations - get
  public function listPaymentMethodConfigurations($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->paymentMethodConfigurations->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_method_configurations - post
  public function createPaymentMethodConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->paymentMethodConfigurations->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_method_configurations/{configuration} - get
  public function retrievePaymentMethodConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'configuration');
    $configuration = $options->configuration;
    unset($options->configuration);
    return $this->stripe->paymentMethodConfigurations->retrieve($configuration, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_method_configurations/{configuration} - post
  public function updatePaymentMethodConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'configuration');
    $configuration = $options->configuration;
    unset($options->configuration);
    return $this->stripe->paymentMethodConfigurations->update($configuration, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_method_domains - get
  public function listPaymentMethodDomains($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->paymentMethodDomains->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_method_domains - post
  public function createPaymentMethodDomain($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->paymentMethodDomains->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_method_domains/{payment_method_domain} - get
  public function retrievePaymentMethodDomain($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_method_domain');
    $payment_method_domain = $options->payment_method_domain;
    unset($options->payment_method_domain);
    return $this->stripe->paymentMethodDomains->retrieve($payment_method_domain, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_method_domains/{payment_method_domain} - post
  public function updatePaymentMethodDomain($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_method_domain');
    $payment_method_domain = $options->payment_method_domain;
    unset($options->payment_method_domain);
    return $this->stripe->paymentMethodDomains->update($payment_method_domain, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_method_domains/{payment_method_domain}/validate - post
  public function validatePaymentMethodDomain($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_method_domain');
    $payment_method_domain = $options->payment_method_domain;
    unset($options->payment_method_domain);
    return $this->stripe->paymentMethodDomains->validate($payment_method_domain, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_methods - get
  public function listPaymentMethods($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->paymentMethods->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_methods - post
  public function createPaymentMethod($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->paymentMethods->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_methods/{payment_method} - get
  public function retrievePaymentMethod($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_method');
    $payment_method = $options->payment_method;
    unset($options->payment_method);
    return $this->stripe->paymentMethods->retrieve($payment_method, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_methods/{payment_method} - post
  public function updatePaymentMethod($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_method');
    $payment_method = $options->payment_method;
    unset($options->payment_method);
    return $this->stripe->paymentMethods->update($payment_method, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_methods/{payment_method}/attach - post
  public function attachPaymentMethod($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_method');
    $payment_method = $options->payment_method;
    unset($options->payment_method);
    return $this->stripe->paymentMethods->attach($payment_method, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payment_methods/{payment_method}/detach - post
  public function detachPaymentMethod($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payment_method');
    $payment_method = $options->payment_method;
    unset($options->payment_method);
    return $this->stripe->paymentMethods->detach($payment_method, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payouts - get
  public function listPayouts($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->payouts->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payouts - post
  public function createPayout($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->payouts->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payouts/{payout} - get
  public function retrievePayout($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payout');
    $payout = $options->payout;
    unset($options->payout);
    return $this->stripe->payouts->retrieve($payout, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payouts/{payout} - post
  public function updatePayout($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payout');
    $payout = $options->payout;
    unset($options->payout);
    return $this->stripe->payouts->update($payout, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payouts/{payout}/cancel - post
  public function cancelPayout($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payout');
    $payout = $options->payout;
    unset($options->payout);
    return $this->stripe->payouts->cancel($payout, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/payouts/{payout}/reverse - post
  public function reversePayout($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'payout');
    $payout = $options->payout;
    unset($options->payout);
    return $this->stripe->payouts->reverse($payout, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/plans - get
  public function listPlans($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->plans->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/plans - post
  public function createPlan($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->plans->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/plans/{plan} - delete
  public function deletePlan($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'plan');
    $plan = $options->plan;
    unset($options->plan);
    return $this->stripe->plans->delete($plan, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/plans/{plan} - get
  public function retrievePlan($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'plan');
    $plan = $options->plan;
    unset($options->plan);
    return $this->stripe->plans->retrieve($plan, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/plans/{plan} - post
  public function updatePlan($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'plan');
    $plan = $options->plan;
    unset($options->plan);
    return $this->stripe->plans->update($plan, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/prices - get
  public function listPrices($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->prices->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/prices - post
  public function createPrice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->prices->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/prices/search - get
  public function searchPrices($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'query');
    return $this->stripe->prices->search(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/prices/{price} - get
  public function retrievePrice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'price');
    $price = $options->price;
    unset($options->price);
    return $this->stripe->prices->retrieve($price, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/prices/{price} - post
  public function updatePrice($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'price');
    $price = $options->price;
    unset($options->price);
    return $this->stripe->prices->update($price, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/products - get
  public function listProducts($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->products->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/products - post
  public function createProduct($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->products->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/products/search - get
  public function searchProducts($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'query');
    return $this->stripe->products->search(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/products/{id} - delete
  public function deleteProduct($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->products->delete($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/products/{id} - get
  public function retrieveProduct($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->products->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/products/{id} - post
  public function updateProduct($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->products->update($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/promotion_codes - get
  public function listPromotionCodes($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->promotionCodes->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/promotion_codes - post
  public function createPromotionCode($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->promotionCodes->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/promotion_codes/{promotion_code} - get
  public function retrievePromotionCode($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'promotion_code');
    $promotion_code = $options->promotion_code;
    unset($options->promotion_code);
    return $this->stripe->promotionCodes->retrieve($promotion_code, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/promotion_codes/{promotion_code} - post
  public function updatePromotionCode($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'promotion_code');
    $promotion_code = $options->promotion_code;
    unset($options->promotion_code);
    return $this->stripe->promotionCodes->update($promotion_code, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes - get
  public function listQuotes($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->quotes->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes - post
  public function createQuote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->quotes->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes/{quote} - get
  public function retrieveQuote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'quote');
    $quote = $options->quote;
    unset($options->quote);
    return $this->stripe->quotes->retrieve($quote, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes/{quote} - post
  public function updateQuote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'quote');
    $quote = $options->quote;
    unset($options->quote);
    return $this->stripe->quotes->update($quote, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes/{quote}/accept - post
  public function acceptQuote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'quote');
    $quote = $options->quote;
    unset($options->quote);
    return $this->stripe->quotes->accept($quote, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes/{quote}/cancel - post
  public function cancelQuote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'quote');
    $quote = $options->quote;
    unset($options->quote);
    return $this->stripe->quotes->cancel($quote, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes/{quote}/computed_upfront_line_items - get
  public function listQuoteComputedUpfrontLineItems($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'quote');
    $quote = $options->quote;
    unset($options->quote);
    return $this->stripe->quotes->listComputedUpfrontLineItems($quote, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes/{quote}/finalize - post
  public function finalizeQuote($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'quote');
    $quote = $options->quote;
    unset($options->quote);
    return $this->stripe->quotes->finalize($quote, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes/{quote}/line_items - get
  public function listQuoteLineItems($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'quote');
    $quote = $options->quote;
    unset($options->quote);
    return $this->stripe->quotes->listLineItems($quote, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/quotes/{quote}/pdf - get
  public function retrieveQuotePdf($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'quote');
    $quote = $options->quote;
    unset($options->quote);
    return $this->stripe->quotes->retrievePdf($quote, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/early_fraud_warnings - get
  public function listRadarEarlyFraudWarnings($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->radar->earlyFraudWarnings->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/early_fraud_warnings/{early_fraud_warning} - get
  public function retrieveRadarEarlyFraudWarning($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'early_fraud_warning');
    $early_fraud_warning = $options->early_fraud_warning;
    unset($options->early_fraud_warning);
    return $this->stripe->radar->earlyFraudWarnings->retrieve($early_fraud_warning, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/value_list_items - get
  public function listRadarValueListItems($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'value_list');
    return $this->stripe->radar->valueListItems->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/value_list_items - post
  public function createRadarValueListItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->radar->valueListItems->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/value_list_items/{item} - delete
  public function deleteRadarValueListItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'item');
    $item = $options->item;
    unset($options->item);
    return $this->stripe->radar->valueListItems->delete($item, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/value_list_items/{item} - get
  public function retrieveRadarValueListItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'item');
    $item = $options->item;
    unset($options->item);
    return $this->stripe->radar->valueListItems->retrieve($item, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/value_lists - get
  public function listRadarValueLists($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->radar->valueLists->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/value_lists - post
  public function createRadarValueList($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->radar->valueLists->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/value_lists/{value_list} - delete
  public function deleteRadarValueList($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'value_list');
    $value_list = $options->value_list;
    unset($options->value_list);
    return $this->stripe->radar->valueLists->delete($value_list, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/value_lists/{value_list} - get
  public function retrieveRadarValueList($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'value_list');
    $value_list = $options->value_list;
    unset($options->value_list);
    return $this->stripe->radar->valueLists->retrieve($value_list, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/radar/value_lists/{value_list} - post
  public function updateRadarValueList($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'value_list');
    $value_list = $options->value_list;
    unset($options->value_list);
    return $this->stripe->radar->valueLists->update($value_list, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/refunds - get
  public function listRefunds($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->refunds->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/refunds - post
  public function createRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->refunds->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/refunds/{refund} - get
  public function retrieveRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'refund');
    $refund = $options->refund;
    unset($options->refund);
    return $this->stripe->refunds->retrieve($refund, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/refunds/{refund} - post
  public function updateRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'refund');
    $refund = $options->refund;
    unset($options->refund);
    return $this->stripe->refunds->update($refund, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/refunds/{refund}/cancel - post
  public function cancelRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'refund');
    $refund = $options->refund;
    unset($options->refund);
    return $this->stripe->refunds->cancel($refund, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/reporting/report_runs - get
  public function listReportingReportRuns($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->reporting->reportRuns->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/reporting/report_runs - post
  public function createReportingReportRun($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->reporting->reportRuns->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/reporting/report_runs/{report_run} - get
  public function retrieveReportingReportRun($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'report_run');
    $report_run = $options->report_run;
    unset($options->report_run);
    return $this->stripe->reporting->reportRuns->retrieve($report_run, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/reporting/report_types - get
  public function listReportingReportTypes($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->reporting->reportTypes->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/reporting/report_types/{report_type} - get
  public function retrieveReportingReportType($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'report_type');
    $report_type = $options->report_type;
    unset($options->report_type);
    return $this->stripe->reporting->reportTypes->retrieve($report_type, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/reviews - get
  public function listReviews($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->reviews->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/reviews/{review} - get
  public function retrieveReview($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'review');
    $review = $options->review;
    unset($options->review);
    return $this->stripe->reviews->retrieve($review, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/reviews/{review}/approve - post
  public function approveReview($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'review');
    $review = $options->review;
    unset($options->review);
    return $this->stripe->reviews->approve($review, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/setup_attempts - get
  public function listSetupAttempts($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'setup_intent');
    return $this->stripe->setupAttempts->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/setup_intents - get
  public function listSetupIntents($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->setupIntents->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/setup_intents - post
  public function createSetupIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    return $this->stripe->setupIntents->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/setup_intents/{intent} - get
  public function retrieveSetupIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->setupIntents->retrieve($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/setup_intents/{intent} - post
  public function updateSetupIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->setupIntents->update($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/setup_intents/{intent}/cancel - post
  public function cancelSetupIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->setupIntents->cancel($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/setup_intents/{intent}/confirm - post
  public function confirmSetupIntent($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    return $this->stripe->setupIntents->confirm($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/setup_intents/{intent}/verify_microdeposits - post
  public function createSetupIntentVerifyMicrodeposit($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'intent');
    $intent = $options->intent;
    unset($options->intent);
    return $this->stripe->setupIntents->createVerifyMicrodeposit($intent, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/shipping_rates - get
  public function listShippingRates($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->shippingRates->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/shipping_rates - post
  public function createShippingRate($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->shippingRates->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/shipping_rates/{shipping_rate_token} - get
  public function retrieveShippingRate($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'shipping_rate_token');
    $shipping_rate_token = $options->shipping_rate_token;
    unset($options->shipping_rate_token);
    return $this->stripe->shippingRates->retrieve($shipping_rate_token, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/shipping_rates/{shipping_rate_token} - post
  public function updateShippingRate($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'shipping_rate_token');
    $shipping_rate_token = $options->shipping_rate_token;
    unset($options->shipping_rate_token);
    return $this->stripe->shippingRates->update($shipping_rate_token, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/sigma/scheduled_query_runs - get
  public function listSigmaScheduledQueryRuns($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->sigma->scheduledQueryRuns->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/sigma/scheduled_query_runs/{scheduled_query_run} - get
  public function retrieveSigmaScheduledQueryRun($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'scheduled_query_run');
    $scheduled_query_run = $options->scheduled_query_run;
    unset($options->scheduled_query_run);
    return $this->stripe->sigma->scheduledQueryRuns->retrieve($scheduled_query_run, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/sources - post
  public function createSource($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->sources->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/sources/{source} - get
  public function retrieveSource($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'source');
    $source = $options->source;
    unset($options->source);
    return $this->stripe->sources->retrieve($source, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/sources/{source} - post
  public function updateSource($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'source');
    $source = $options->source;
    unset($options->source);
    return $this->stripe->sources->update($source, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/sources/{source}/source_transactions - get
  public function listSourceSourceTransactions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'source');
    $source = $options->source;
    unset($options->source);
    return $this->stripe->sources->listSourceTransactions($source, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/sources/{source}/verify - post
  public function verifySource($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'source');
    $source = $options->source;
    unset($options->source);
    return $this->stripe->sources->verify($source, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_items - get
  public function listSubscriptionItems($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'subscription');
    return $this->stripe->subscriptionItems->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_items - post
  public function createSubscriptionItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->subscriptionItems->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_items/{item} - delete
  public function deleteSubscriptionItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'item');
    $item = $options->item;
    unset($options->item);
    return $this->stripe->subscriptionItems->delete($item, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_items/{item} - get
  public function retrieveSubscriptionItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'item');
    $item = $options->item;
    unset($options->item);
    return $this->stripe->subscriptionItems->retrieve($item, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_items/{item} - post
  public function updateSubscriptionItem($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'item');
    $item = $options->item;
    unset($options->item);
    return $this->stripe->subscriptionItems->update($item, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_items/{subscription_item}/usage_record_summaries - get
  public function listSubscriptionItemUsageRecordSummaries($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'subscription_item');
    $subscription_item = $options->subscription_item;
    unset($options->subscription_item);
    return $this->stripe->subscriptionItems->listUsageRecordSummaries($subscription_item, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_items/{subscription_item}/usage_records - post
  public function createSubscriptionItemUsageRecord($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'subscription_item');
    $subscription_item = $options->subscription_item;
    unset($options->subscription_item);
    return $this->stripe->subscriptionItems->createUsageRecord($subscription_item, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_schedules - get
  public function listSubscriptionSchedules($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->subscriptionSchedules->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_schedules - post
  public function createSubscriptionSchedule($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->subscriptionSchedules->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_schedules/{schedule} - get
  public function retrieveSubscriptionSchedule($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'schedule');
    $schedule = $options->schedule;
    unset($options->schedule);
    return $this->stripe->subscriptionSchedules->retrieve($schedule, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_schedules/{schedule} - post
  public function updateSubscriptionSchedule($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'schedule');
    $schedule = $options->schedule;
    unset($options->schedule);
    return $this->stripe->subscriptionSchedules->update($schedule, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_schedules/{schedule}/cancel - post
  public function cancelSubscriptionSchedule($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'schedule');
    $schedule = $options->schedule;
    unset($options->schedule);
    return $this->stripe->subscriptionSchedules->cancel($schedule, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscription_schedules/{schedule}/release - post
  public function releaseSubscriptionSchedule($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'schedule');
    $schedule = $options->schedule;
    unset($options->schedule);
    return $this->stripe->subscriptionSchedules->release($schedule, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscriptions - get
  public function listSubscriptions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->subscriptions->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscriptions - post
  public function createSubscription($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->subscriptions->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscriptions/search - get
  public function searchSubscriptions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'query');
    return $this->stripe->subscriptions->search(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscriptions/{subscription_exposed_id} - delete
  public function deleteSubscription($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'subscription_exposed_id');
    $subscription_exposed_id = $options->subscription_exposed_id;
    unset($options->subscription_exposed_id);
    return $this->stripe->subscriptions->delete($subscription_exposed_id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscriptions/{subscription_exposed_id} - get
  public function retrieveSubscription($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'subscription_exposed_id');
    $subscription_exposed_id = $options->subscription_exposed_id;
    unset($options->subscription_exposed_id);
    return $this->stripe->subscriptions->retrieve($subscription_exposed_id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscriptions/{subscription_exposed_id} - post
  public function updateSubscription($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'subscription_exposed_id');
    $subscription_exposed_id = $options->subscription_exposed_id;
    unset($options->subscription_exposed_id);
    return $this->stripe->subscriptions->update($subscription_exposed_id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscriptions/{subscription_exposed_id}/discount - delete
  public function deleteSubscriptionDiscount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'subscription_exposed_id');
    $subscription_exposed_id = $options->subscription_exposed_id;
    unset($options->subscription_exposed_id);
    return $this->stripe->subscriptions->deleteDiscount($subscription_exposed_id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/subscriptions/{subscription}/resume - post
  public function resumeSubscription($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'subscription');
    $subscription = $options->subscription;
    unset($options->subscription);
    return $this->stripe->subscriptions->resume($subscription, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/calculations - post
  public function createTaxCalculation($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->tax->calculations->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/calculations/{calculation}/line_items - get
  public function listTaxCalculationLineItems($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'calculation');
    $calculation = $options->calculation;
    unset($options->calculation);
    return $this->stripe->tax->calculations->listLineItems($calculation, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/registrations - get
  public function listTaxRegistrations($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->tax->registrations->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/registrations - post
  public function createTaxRegistration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->tax->registrations->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/registrations/{id} - get
  public function retrieveTaxRegistration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->tax->registrations->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/registrations/{id} - post
  public function updateTaxRegistration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->tax->registrations->update($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/settings - get
  public function retrieveTaxSetting($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->tax->settings->retrieve(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/settings - post
  public function createTaxSetting($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->tax->settings->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/transactions/create_from_calculation - post
  public function createTaxTransactionsCreateFromCalculation($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->tax->transactions->createFromCalculation->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/transactions/create_reversal - post
  public function createTaxTransactionsCreateReversal($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->tax->transactions->createReversal->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/transactions/{transaction} - get
  public function retrieveTaxTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'transaction');
    $transaction = $options->transaction;
    unset($options->transaction);
    return $this->stripe->tax->transactions->retrieve($transaction, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax/transactions/{transaction}/line_items - get
  public function listTaxTransactionLineItems($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'transaction');
    $transaction = $options->transaction;
    unset($options->transaction);
    return $this->stripe->tax->transactions->listLineItems($transaction, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_codes - get
  public function listTaxCodes($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->taxCodes->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_codes/{id} - get
  public function retrieveTaxCode($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->taxCodes->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_ids - get
  public function listTaxIds($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->taxIds->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_ids - post
  public function createTaxId($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->taxIds->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_ids/{id} - delete
  public function deleteTaxId($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->taxIds->delete($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_ids/{id} - get
  public function retrieveTaxId($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->taxIds->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_rates - get
  public function listTaxRates($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->taxRates->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_rates - post
  public function createTaxRate($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->taxRates->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_rates/{tax_rate} - get
  public function retrieveTaxRate($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'tax_rate');
    $tax_rate = $options->tax_rate;
    unset($options->tax_rate);
    return $this->stripe->taxRates->retrieve($tax_rate, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tax_rates/{tax_rate} - post
  public function updateTaxRate($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'tax_rate');
    $tax_rate = $options->tax_rate;
    unset($options->tax_rate);
    return $this->stripe->taxRates->update($tax_rate, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/configurations - get
  public function listTerminalConfigurations($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->terminal->configurations->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/configurations - post
  public function createTerminalConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->terminal->configurations->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/configurations/{configuration} - delete
  public function deleteTerminalConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'configuration');
    $configuration = $options->configuration;
    unset($options->configuration);
    return $this->stripe->terminal->configurations->delete($configuration, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/configurations/{configuration} - get
  public function retrieveTerminalConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'configuration');
    $configuration = $options->configuration;
    unset($options->configuration);
    return $this->stripe->terminal->configurations->retrieve($configuration, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/configurations/{configuration} - post
  public function updateTerminalConfiguration($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'configuration');
    $configuration = $options->configuration;
    unset($options->configuration);
    return $this->stripe->terminal->configurations->update($configuration, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/connection_tokens - post
  public function createTerminalConnectionToken($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->terminal->connectionTokens->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/locations - get
  public function listTerminalLocations($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->terminal->locations->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/locations - post
  public function createTerminalLocation($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->terminal->locations->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/locations/{location} - delete
  public function deleteTerminalLocation($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'location');
    $location = $options->location;
    unset($options->location);
    return $this->stripe->terminal->locations->delete($location, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/locations/{location} - get
  public function retrieveTerminalLocation($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'location');
    $location = $options->location;
    unset($options->location);
    return $this->stripe->terminal->locations->retrieve($location, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/locations/{location} - post
  public function updateTerminalLocation($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'location');
    $location = $options->location;
    unset($options->location);
    return $this->stripe->terminal->locations->update($location, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers - get
  public function listTerminalReaders($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->terminal->readers->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers - post
  public function createTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->terminal->readers->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers/{reader} - delete
  public function deleteTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'reader');
    $reader = $options->reader;
    unset($options->reader);
    return $this->stripe->terminal->readers->delete($reader, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers/{reader} - get
  public function retrieveTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'reader');
    $reader = $options->reader;
    unset($options->reader);
    return $this->stripe->terminal->readers->retrieve($reader, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers/{reader} - post
  public function updateTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'reader');
    $reader = $options->reader;
    unset($options->reader);
    return $this->stripe->terminal->readers->update($reader, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers/{reader}/cancel_action - post
  public function cancelActionTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'reader');
    $reader = $options->reader;
    unset($options->reader);
    return $this->stripe->terminal->readers->cancelAction($reader, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers/{reader}/process_payment_intent - post
  public function processPaymentIntentTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'reader');
    $reader = $options->reader;
    unset($options->reader);
    return $this->stripe->terminal->readers->processPaymentIntent($reader, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers/{reader}/process_setup_intent - post
  public function processSetupIntentTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'reader');
    $reader = $options->reader;
    unset($options->reader);
    return $this->stripe->terminal->readers->processSetupIntent($reader, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers/{reader}/refund_payment - post
  public function refundPaymentTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'reader');
    $reader = $options->reader;
    unset($options->reader);
    return $this->stripe->terminal->readers->refundPayment($reader, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/terminal/readers/{reader}/set_reader_display - post
  public function setReaderDisplayTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'reader');
    $reader = $options->reader;
    unset($options->reader);
    return $this->stripe->terminal->readers->setReaderDisplay($reader, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/confirmation_tokens - post
  public function createTestHelpersConfirmationToken($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    if (isset($options->return_url) && !strpos($options->return_url, '://')) {
      $options->return_url = $this->app->parse('{{$_SERVER.BASE_URL}}') . $options->return_url;
    }
    return $this->stripe->testHelpers->confirmationTokens->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/customers/{customer}/fund_cash_balance - post
  public function fundCashBalanceTestHelpersCustomer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'customer');
    $customer = $options->customer;
    unset($options->customer);
    return $this->stripe->testHelpers->customers->fundCashBalance($customer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/authorizations - post
  public function createTestHelpersIssuingAuthorization($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->testHelpers->createIssuingAuthorizations(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/authorizations/{authorization}/capture - post
  public function captureTestHelpersIssuingAuthorization($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'authorization');
    $authorization = $options->authorization;
    unset($options->authorization);
    return $this->stripe->testHelpers->issuing->authorizations->capture($authorization, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/authorizations/{authorization}/expire - post
  public function expireTestHelpersIssuingAuthorization($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'authorization');
    $authorization = $options->authorization;
    unset($options->authorization);
    return $this->stripe->testHelpers->issuing->authorizations->expire($authorization, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/authorizations/{authorization}/increment - post
  public function incrementTestHelpersIssuingAuthorization($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'authorization');
    $authorization = $options->authorization;
    unset($options->authorization);
    return $this->stripe->testHelpers->issuing->authorizations->increment($authorization, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/authorizations/{authorization}/reverse - post
  public function reverseTestHelpersIssuingAuthorization($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'authorization');
    $authorization = $options->authorization;
    unset($options->authorization);
    return $this->stripe->testHelpers->issuing->authorizations->reverse($authorization, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/cards/{card}/shipping/deliver - post
  public function createTestHelpersIssuingCardShipping($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'card');
    $card = $options->card;
    unset($options->card);
    return $this->stripe->testHelpers->issuing->cards->createShipping($card, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/personalization_designs/{personalization_design}/activate - post
  public function activateTestHelpersIssuingPersonalizationDesign($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'personalization_design');
    $personalization_design = $options->personalization_design;
    unset($options->personalization_design);
    return $this->stripe->testHelpers->issuing->personalizationDesigns->activate($personalization_design, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/personalization_designs/{personalization_design}/deactivate - post
  public function deactivateTestHelpersIssuingPersonalizationDesign($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'personalization_design');
    $personalization_design = $options->personalization_design;
    unset($options->personalization_design);
    return $this->stripe->testHelpers->issuing->personalizationDesigns->deactivate($personalization_design, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/personalization_designs/{personalization_design}/reject - post
  public function rejectTestHelpersIssuingPersonalizationDesign($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'personalization_design');
    $personalization_design = $options->personalization_design;
    unset($options->personalization_design);
    return $this->stripe->testHelpers->issuing->personalizationDesigns->reject($personalization_design, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/transactions/create_force_capture - post
  public function createTestHelpersIssuingTransactionsCreateForceCapture($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->testHelpers->issuing->transactions->createForceCapture->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/transactions/create_unlinked_refund - post
  public function createTestHelpersIssuingTransactionsCreateUnlinkedRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->testHelpers->issuing->transactions->createUnlinkedRefund->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/issuing/transactions/{transaction}/refund - post
  public function refundTestHelpersIssuingTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'transaction');
    $transaction = $options->transaction;
    unset($options->transaction);
    return $this->stripe->testHelpers->issuing->transactions->refund($transaction, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/refunds/{refund}/expire - post
  public function expireTestHelpersRefund($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'refund');
    $refund = $options->refund;
    unset($options->refund);
    return $this->stripe->testHelpers->refunds->expire($refund, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/terminal/readers/{reader}/present_payment_method - post
  public function presentPaymentMethodTestHelpersTerminalReader($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'reader');
    $reader = $options->reader;
    unset($options->reader);
    return $this->stripe->testHelpers->terminal->readers->presentPaymentMethod($reader, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/test_clocks - get
  public function listTestHelpersTestClocks($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->testHelpers->testClocks->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/test_clocks - post
  public function createTestHelpersTestClock($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->testHelpers->testClocks->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/test_clocks/{test_clock} - delete
  public function deleteTestHelpersTestClock($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'test_clock');
    $test_clock = $options->test_clock;
    unset($options->test_clock);
    return $this->stripe->testHelpers->testClocks->delete($test_clock, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/test_clocks/{test_clock} - get
  public function retrieveTestHelpersTestClock($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'test_clock');
    $test_clock = $options->test_clock;
    unset($options->test_clock);
    return $this->stripe->testHelpers->testClocks->retrieve($test_clock, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/test_clocks/{test_clock}/advance - post
  public function advanceTestHelpersTestClock($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'test_clock');
    $test_clock = $options->test_clock;
    unset($options->test_clock);
    return $this->stripe->testHelpers->testClocks->advance($test_clock, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/inbound_transfers/{id}/fail - post
  public function failTestHelpersTreasuryInboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->testHelpers->treasury->inboundTransfers->fail($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/inbound_transfers/{id}/return - post
  public function returnTestHelpersTreasuryInboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->testHelpers->treasury->inboundTransfers->return($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/inbound_transfers/{id}/succeed - post
  public function succeedTestHelpersTreasuryInboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->testHelpers->treasury->inboundTransfers->succeed($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/outbound_payments/{id}/fail - post
  public function failTestHelpersTreasuryOutboundPayment($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->testHelpers->treasury->outboundPayments->fail($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/outbound_payments/{id}/post - post
  public function postTestHelpersTreasuryOutboundPayment($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->testHelpers->treasury->outboundPayments->post($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/outbound_payments/{id}/return - post
  public function returnTestHelpersTreasuryOutboundPayment($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->testHelpers->treasury->outboundPayments->return($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/outbound_transfers/{outbound_transfer}/fail - post
  public function failTestHelpersTreasuryOutboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'outbound_transfer');
    $outbound_transfer = $options->outbound_transfer;
    unset($options->outbound_transfer);
    return $this->stripe->testHelpers->treasury->outboundTransfers->fail($outbound_transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/outbound_transfers/{outbound_transfer}/post - post
  public function postTestHelpersTreasuryOutboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'outbound_transfer');
    $outbound_transfer = $options->outbound_transfer;
    unset($options->outbound_transfer);
    return $this->stripe->testHelpers->treasury->outboundTransfers->post($outbound_transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/outbound_transfers/{outbound_transfer}/return - post
  public function returnTestHelpersTreasuryOutboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'outbound_transfer');
    $outbound_transfer = $options->outbound_transfer;
    unset($options->outbound_transfer);
    return $this->stripe->testHelpers->treasury->outboundTransfers->return($outbound_transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/received_credits - post
  public function createTestHelpersTreasuryReceivedCredit($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->testHelpers->createTreasuryReceivedCredits(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/test_helpers/treasury/received_debits - post
  public function createTestHelpersTreasuryReceivedDebit($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->testHelpers->createTreasuryReceivedDebits(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tokens - post
  public function createToken($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->tokens->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/tokens/{token} - get
  public function retrieveToken($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'token');
    $token = $options->token;
    unset($options->token);
    return $this->stripe->tokens->retrieve($token, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/topups - get
  public function listTopups($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->topups->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/topups - post
  public function createTopup($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->topups->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/topups/{topup} - get
  public function retrieveTopup($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'topup');
    $topup = $options->topup;
    unset($options->topup);
    return $this->stripe->topups->retrieve($topup, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/topups/{topup} - post
  public function updateTopup($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'topup');
    $topup = $options->topup;
    unset($options->topup);
    return $this->stripe->topups->update($topup, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/topups/{topup}/cancel - post
  public function cancelTopup($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'topup');
    $topup = $options->topup;
    unset($options->topup);
    return $this->stripe->topups->cancel($topup, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/transfers - get
  public function listTransfers($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->transfers->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/transfers - post
  public function createTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->transfers->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/transfers/{id}/reversals - get
  public function listTransferReversals($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->transfers->listReversals($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/transfers/{id}/reversals - post
  public function createTransferReversal($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->transfers->createReversal($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/transfers/{transfer} - get
  public function retrieveTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'transfer');
    $transfer = $options->transfer;
    unset($options->transfer);
    return $this->stripe->transfers->retrieve($transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/transfers/{transfer} - post
  public function updateTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'transfer');
    $transfer = $options->transfer;
    unset($options->transfer);
    return $this->stripe->transfers->update($transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/transfers/{transfer}/reversals/{id} - get
  public function retrieveTransferReversal($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    option_require($options, 'transfer');
    $transfer = $options->transfer;
    unset($options->transfer);
    return $this->stripe->transfers->retrieveReversal($id, $transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/transfers/{transfer}/reversals/{id} - post
  public function updateTransferReversal($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    option_require($options, 'transfer');
    $transfer = $options->transfer;
    unset($options->transfer);
    return $this->stripe->transfers->updateReversal($id, $transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/credit_reversals - get
  public function listTreasuryCreditReversals($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    return $this->stripe->treasury->creditReversals->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/credit_reversals - post
  public function createTreasuryCreditReversal($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->treasury->creditReversals->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/credit_reversals/{credit_reversal} - get
  public function retrieveTreasuryCreditReversal($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'credit_reversal');
    $credit_reversal = $options->credit_reversal;
    unset($options->credit_reversal);
    return $this->stripe->treasury->creditReversals->retrieve($credit_reversal, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/debit_reversals - get
  public function listTreasuryDebitReversals($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    return $this->stripe->treasury->debitReversals->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/debit_reversals - post
  public function createTreasuryDebitReversal($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->treasury->debitReversals->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/debit_reversals/{debit_reversal} - get
  public function retrieveTreasuryDebitReversal($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'debit_reversal');
    $debit_reversal = $options->debit_reversal;
    unset($options->debit_reversal);
    return $this->stripe->treasury->debitReversals->retrieve($debit_reversal, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/financial_accounts - get
  public function listTreasuryFinancialAccounts($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->treasury->financialAccounts->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/financial_accounts - post
  public function createTreasuryFinancialAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->treasury->financialAccounts->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/financial_accounts/{financial_account} - get
  public function retrieveTreasuryFinancialAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    $financial_account = $options->financial_account;
    unset($options->financial_account);
    return $this->stripe->treasury->financialAccounts->retrieve($financial_account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/financial_accounts/{financial_account} - post
  public function updateTreasuryFinancialAccount($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    $financial_account = $options->financial_account;
    unset($options->financial_account);
    return $this->stripe->treasury->financialAccounts->update($financial_account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/financial_accounts/{financial_account}/features - get
  public function retrieveTreasuryFinancialAccountFeature($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    $financial_account = $options->financial_account;
    unset($options->financial_account);
    return $this->stripe->treasury->financialAccounts->retrieveFeature($financial_account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/financial_accounts/{financial_account}/features - post
  public function createTreasuryFinancialAccountFeature($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    $financial_account = $options->financial_account;
    unset($options->financial_account);
    return $this->stripe->treasury->financialAccounts->createFeature($financial_account, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/inbound_transfers - get
  public function listTreasuryInboundTransfers($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    return $this->stripe->treasury->inboundTransfers->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/inbound_transfers - post
  public function createTreasuryInboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->treasury->inboundTransfers->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/inbound_transfers/{id} - get
  public function retrieveTreasuryInboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->treasury->inboundTransfers->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/inbound_transfers/{inbound_transfer}/cancel - post
  public function cancelTreasuryInboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'inbound_transfer');
    $inbound_transfer = $options->inbound_transfer;
    unset($options->inbound_transfer);
    return $this->stripe->treasury->inboundTransfers->cancel($inbound_transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/outbound_payments - get
  public function listTreasuryOutboundPayments($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    return $this->stripe->treasury->outboundPayments->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/outbound_payments - post
  public function createTreasuryOutboundPayment($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->treasury->outboundPayments->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/outbound_payments/{id} - get
  public function retrieveTreasuryOutboundPayment($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->treasury->outboundPayments->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/outbound_payments/{id}/cancel - post
  public function cancelTreasuryOutboundPayment($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->treasury->outboundPayments->cancel($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/outbound_transfers - get
  public function listTreasuryOutboundTransfers($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    return $this->stripe->treasury->outboundTransfers->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/outbound_transfers - post
  public function createTreasuryOutboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->treasury->outboundTransfers->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/outbound_transfers/{outbound_transfer} - get
  public function retrieveTreasuryOutboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'outbound_transfer');
    $outbound_transfer = $options->outbound_transfer;
    unset($options->outbound_transfer);
    return $this->stripe->treasury->outboundTransfers->retrieve($outbound_transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/outbound_transfers/{outbound_transfer}/cancel - post
  public function cancelTreasuryOutboundTransfer($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'outbound_transfer');
    $outbound_transfer = $options->outbound_transfer;
    unset($options->outbound_transfer);
    return $this->stripe->treasury->outboundTransfers->cancel($outbound_transfer, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/received_credits - get
  public function listTreasuryReceivedCredits($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    return $this->stripe->treasury->receivedCredits->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/received_credits/{id} - get
  public function retrieveTreasuryReceivedCredit($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->treasury->receivedCredits->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/received_debits - get
  public function listTreasuryReceivedDebits($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    return $this->stripe->treasury->receivedDebits->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/received_debits/{id} - get
  public function retrieveTreasuryReceivedDebit($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->treasury->receivedDebits->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/transaction_entries - get
  public function listTreasuryTransactionEntries($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    return $this->stripe->treasury->transactionEntries->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/transaction_entries/{id} - get
  public function retrieveTreasuryTransactionEntrie($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->treasury->transactionEntries->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/transactions - get
  public function listTreasuryTransactions($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'financial_account');
    return $this->stripe->treasury->transactions->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/treasury/transactions/{id} - get
  public function retrieveTreasuryTransaction($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'id');
    $id = $options->id;
    unset($options->id);
    return $this->stripe->treasury->transactions->retrieve($id, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/webhook_endpoints - get
  public function listWebhookEndpoints($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->webhookEndpoints->all(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/webhook_endpoints - post
  public function createWebhookEndpoint($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    return $this->stripe->webhookEndpoints->create(json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/webhook_endpoints/{webhook_endpoint} - delete
  public function deleteWebhookEndpoint($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'webhook_endpoint');
    $webhook_endpoint = $options->webhook_endpoint;
    unset($options->webhook_endpoint);
    return $this->stripe->webhookEndpoints->delete($webhook_endpoint, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/webhook_endpoints/{webhook_endpoint} - get
  public function retrieveWebhookEndpoint($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'webhook_endpoint');
    $webhook_endpoint = $options->webhook_endpoint;
    unset($options->webhook_endpoint);
    return $this->stripe->webhookEndpoints->retrieve($webhook_endpoint, json_decode(json_encode($options), true),$__extra)->toArray();
  }

  // /v1/webhook_endpoints/{webhook_endpoint} - post
  public function updateWebhookEndpoint($options) {
    $options = $this->app->parseObject($options, NULL, TRUE);
    $__extra = isset($options->__extra) ? (array)$options->__extra : null;
    if (isset($options->__extra)) {
      if (count($__extra) == 0) {
        $__extra = null;
      }
      unset($options->__extra);
    }

    option_require($options, 'webhook_endpoint');
    $webhook_endpoint = $options->webhook_endpoint;
    unset($options->webhook_endpoint);
    return $this->stripe->webhookEndpoints->update($webhook_endpoint, json_decode(json_encode($options), true),$__extra)->toArray();
  }

}
