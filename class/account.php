<?php

/**
 * hykwWPData_account アカウント関係
 * 
 * @uses baseHykwWPData
 */

class hykwWPData_account extends baseHykwWPData
{
  /**
   * get_id アカウントのIDを取得する
   * 
 例）
 <pre>
   $id = self::get_id('wptestuser');     # $id = 1234
 </pre>
   * 
   * @param string $username アカウント名
   * @return integer アカウントID(取得できなかった時はFALSE)
   */
  public static function get_id($username)
  {
    if ($username == '')
      return FALSE;

    $userinfo = get_user_by('login', $username);
    if ($userinfo == FALSE)
      return FALSE;

    return $userinfo->ID;
  }


}

