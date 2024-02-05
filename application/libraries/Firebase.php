<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
require __DIR__ . '/../../vendor/autoload.php';
use Kreait\ Firebase\ Factory;
use Kreait\ Firebase\ ServiceAccount;
use Kreait\ Firebase\ Auth;
use Kreait\ Firebase\ Messaging\ CloudMessage;

class Firebase {
  protected $config = array();
  protected $serviceAccount;
  private $pesan;

  public function __construct() {
    $this->CI = & get_instance();
    $serviceAccount = ServiceAccount::fromJsonFile( $this->CI->config->item( 'firebase_app_key' ) );
    $firebase = ( new Factory )->withServiceAccount( $serviceAccount )->create();
    $this->pesan = $firebase->getMessaging();
  }
  public function init() {
    return $firebase = ( new Factory )->withServiceAccount( $this->serviceAccount )->create();
  }


  public function init_Auth() {
    return $firebase = ( new Factory )->withServiceAccount( $this->serviceAccount )->createAuth();
  }

  function createUser( $nama, $email, $password, $no_telp, $idUser ) {
    $userProperties = [
      'email' => $email,
      'password' => $password,
      'phoneNumber' => '+62' . $no_telp,
      'displayName' => $nama,
      'uid' => $idUser,
      'disabled' => false
    ];
    $createdUser = $this->init_Auth()->createUser( $userProperties );
  }

  function updateUser( $idUser, $nama, $no_telp, $email ) {
    $uid = $idUser;
    $properties = [
      'email' => $email,
      'displayName' => $nama,
      'phoneNumber' => '+62' . $no_telp
    ];
    $updatedUser = $this->init_Auth()->updateUser( $uid, $properties );
  }

  function deleteUser( $idUser ) {
    $updatedUser = $this->init_Auth()->deleteUser( $idUser );
  }

  function kirim_notifikasi( $token, $judul, $pesan ) {
    $config = AndroidConfig::fromArray( [
      'ttl' => '3600s',
      'priority' => 'high',
      'notification' => [
        'title' => $judul,
        'body' => $pesan,
        'sound' => 'default',
      ],
    ] );
    $message = CloudMessage::withTarget( 'token', $token );
    $message = $message->withAndroidConfig( $config );
    $this->pesan->send( $message );
  }

}