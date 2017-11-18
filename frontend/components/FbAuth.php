<?php 
namespace frontend\components;
use common\models\User;
use Yii;
class FbAuth
{
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    
    public function __construct($alias, $gist)
    {
        $this->client_id='573815686124177'; // ID приложения
        $this->client_secret = '730c4ea4115806e2c43762c47012bede'; // Защищённый ключ
        //$this->redirect_uri = 'http://seostar.require-tests.s-host.net/main/fbauth'; // Адрес сайта
        $this->redirect_uri = 'http://seo-stars.top/'.$gist.'/'.$alias.'?ufrom=fb';
    }
    public function getHref()
    {
        $url = 'https://www.facebook.com/dialog/oauth';
        //$this->redirect_uri=$this->redirect_uri.'?alias='.$alias;
        $params = array(
            'client_id'     => $this->client_id,
            'redirect_uri'  => $this->redirect_uri,
            'response_type' => 'code',
            'scope'         => 'email,user_friends,user_photos,user_actions.music'
        );
        return $url.'?'.urldecode(http_build_query($params));
    }
    public function getToken($code)
    {
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $code,
            'redirect_uri' => $this->redirect_uri
        );
         $url = 'https://graph.facebook.com/oauth/access_token';
        $tokenInfo = null;
        //parse_str(file_get_contents($url . '?' . http_build_query($params)), $tokenInfo);
        $tokenInfo= json_decode(file_get_contents($url . '?' . http_build_query($params)), true);
        return $tokenInfo;
    }
    public function getUserInfo($tokenInfo)
    {
        if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
            $params = array('access_token' => $tokenInfo['access_token']);
    
            $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?fields=id,email,name,picture&' . urldecode(http_build_query($params))), true);
            if (isset($userInfo['id'])) {
                $userInfo = $userInfo;
                $result = true;
            }
        }
        $userInfo['picture']=$userInfo['picture']['data']['url'];
        return $userInfo;
    }
    public function getPhotos($token)
    {      
        if (isset($token['access_token'])) {
            $params = array(
                'access_token' => $token['access_token']
            );
            $userInfo  = json_decode(file_get_contents('https://graph.facebook.com/me/photos' . '?type=tagged&' . urldecode(http_build_query($params))), true);
        }
        return count($userInfo['data'])+1;
    }
    public function getFriends($token)
    {      
        if (isset($token['access_token'])) {
            $params = array(
                //'user_id'=> $token['user_id'],
                'access_token' => $token['access_token']
            );
            $userInfo  = json_decode(file_get_contents('https://graph.facebook.com/me/friends' . '?fields=total_count&' . urldecode(http_build_query($params))), true);
        }
        return $userInfo['summary']['total_count'];
    }

    public function getData($code)
    {    
        $token = $this->getToken($code);
        $userInfo=$this->getUserInfo($token);
        $friends=$this->getFriends($token);
        $photos=$this->getPhotos($token);
        return array_merge($userInfo, ['photos'=>$photos], ['friends'=>$friends]);
    }
    public function loginUser($code)
    {
        $userInfo=$this->getData($code);
        if (isset($userInfo))
        {
            $findUser=User::find()->where(['user_id'=>'fbid'.$userInfo['id']])->one();
            if($findUser)
            {
                Yii::$app->user->login(User::findByUsername('fb_id= '.$userInfo['id']));
                return  $userInfo;
            }
            else
            {
                $user=new User();
                $user->username = 'fb_id= '.$userInfo['id'];
                $user->email = $userInfo['email'] ? "from_fb=".$userInfo['email'] : $userInfo['id'].'noemail@a.a';
                $user->setPassword($userInfo['id']);
                $user->generateAuthKey();
                $user->name=$userInfo['name'];
                $user->friends=$userInfo['friends'];
                $user->photos=$userInfo['photos'];
                $user->user_id='fbid'.$userInfo['id'];
                $user->photo=$userInfo['picture'];
                $user->save();
                Yii::$app->user->login(User::findByUsername('fb_id= '.$userInfo['id']));
                return $userInfo;
            }
        }
        else
            return false;
    }
}

?>