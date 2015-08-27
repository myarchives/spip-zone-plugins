<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

//
// tester la fonction imap_open est dispo
// 
function facteurmonitoring_test_imap_exist() { 
    if (function_exists('imap_open')) {
        return _T('facteurmonitoring:test_imap_exist_true');  
    } else {
        return _T('facteurmonitoring:test_imap_exist_false'); 
    }
} 


//
// tester la connection imap
//  
// la parametre time ne sert uniquement à eviter la mise en cache                        
function facteurmonitoring_test_imap($time) {
   include_spip('inc/config');

   $email = lire_config('facteurmonitoring/email'); 
   $email_pwd = lire_config('facteurmonitoring/email_pwd');
   $hote_imap = lire_config('facteurmonitoring/hote_imap'); 
   $hote_port = lire_config('facteurmonitoring/hote_port'); 
   $hote_inbox = lire_config('facteurmonitoring/inbox'); 
   
   
   if ($hote_imap!="" && function_exists('imap_open')) {
          
          // on se connecte en IMAP pour tester la connection        
          $connection = '{'.$hote_imap.':'.$hote_port.'}'.$hote_inbox;
          $mbox = @imap_open($connection, $email, $email_pwd, OP_READONLY); 
          
          if (FALSE === $mbox) {
                return _T('facteurmonitoring:test_connection_notok');                 
          } else { 
                // lecture boite                  
                $info = imap_check($mbox);
                if (FALSE === $info) {
                    return _T('facteurmonitoring:test_connection_notok');                     
                }  else {
                    return _T('facteurmonitoring:test_connection_ok');
                }
          }
           
   }
   
   return;
}



?>