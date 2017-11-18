<?php 
namespace frontend\components;
use common\models\User;
use Yii;

class VkAuth
{
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    
    public function __construct($alias, $gist)
    {
        $this->client_id='5558007'; // ID приложения
        $this->client_secret = 'AXHgOs45qEKNfLShzcW2'; // Защищённый ключ
        $this->redirect_uri = 'http://seo-stars.top/'.$gist.'/'.$alias.'?ufrom=vk'; // Адрес сайта
    }
    public function getHref()
    {
        $url = 'http://oauth.vk.com/authorize';
        //$this->redirect_uri=$this->redirect_uri.'?alias='.$alias;
        $params = array(
            'client_id'     => $this->client_id,
            'redirect_uri'  => $this->redirect_uri,
            'scope'=>'friends,photos,audio,wall,groups,email',
            'response_type' => 'code'
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
        $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
        return $token;
    }
    public function getUserInfo($token)
    {
        if (isset($token['access_token'])) {
            $params = array(
                'uids'         => $token['user_id'],
                'fields'       => 'uid,first_name,last_name,photo_200_orig,followers_count',
                'access_token' => $token['access_token']
            );
            $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
            if (isset($userInfo['response'][0]['uid'])) {
                $userInfo = $userInfo['response'][0];
                $result = true;
            }
        }
        return $userInfo;
    }
    public function getPhotos($token)
    {      
        if (isset($token['access_token'])) {
            $params = array(
                'owner_id'=> $token['user_id'],
                'album_id'=> 'wall',
                'access_token' => $token['access_token']
            );
            $params2 = array(
                'owner_id'=> $token['user_id'],
                'album_id'=> 'profile',
                'access_token' => $token['access_token']
            );
            $params3 = array(
                'owner_id'=> $token['user_id'],
                'album_id'=> 'saved',
                'access_token' => $token['access_token']
            );
            $userInfo  = json_decode(file_get_contents('https://api.vk.com/method/photos.get' . '?' . urldecode(http_build_query($params))), true);
            $userInfo2  = json_decode(file_get_contents('https://api.vk.com/method/photos.get' . '?' . urldecode(http_build_query($params2))), true);
            $userInfo3  = json_decode(file_get_contents('https://api.vk.com/method/photos.get' . '?' . urldecode(http_build_query($params3))), true);
        }
        return count($userInfo['response'])+count($userInfo2['response'])+count($userInfo3['response']);
    }
    public function getFriends($token)
    {      
        if (isset($token['access_token'])) {
            $params = array(
                'user_id'=> $token['user_id'],
                'access_token' => $token['access_token']
            );
            $userInfo  = json_decode(file_get_contents('https://api.vk.com/method/friends.get' . '?' . urldecode(http_build_query($params))), true);
        }
        return count($userInfo['response']);
    }
    public function getAudios($token)
    {      
        if (isset($token['access_token'])) {
            $params = array(
                'owner_id'=> $token['user_id'],
                'access_token' => $token['access_token']
            );
            $userInfo  = json_decode(file_get_contents('https://api.vk.com/method/audio.getCount' . '?' . urldecode(http_build_query($params))), true);
        }
        return $userInfo['response'];
    }
    public function getGroups($token)
    {      
        if (isset($token['access_token'])) {
            $params = array(
                'user_id'=> $token['user_id'],
                'fields'=>'memebers_count',
                'access_token' => $token['access_token']
            );
            $userInfo  = json_decode(file_get_contents('https://api.vk.com/method/groups.get' . '?' . urldecode(http_build_query($params))), true);
        }
        return count($userInfo['response']);
    }
    public function getData($code)
    {    
        $token = $this->getToken($code);
        $userInfo=$this->getUserInfo($token);
        $photos=$this->getPhotos($token);
        $friends=$this->getFriends($token);
        $audios=$this->getAudios($token);
        $groups=$this->getGroups($token);
        return array_merge($userInfo, ['photos'=>$photos], ['friends'=>$friends], ['audios'=>$audios], ['groups'=>$groups], ['email'=>$token['email']]);
    }
    public function loginUser($code)
    {
        $userInfo=$this->getData($code);
        if (isset($userInfo))
        {
            $findUser=User::find()->where(['user_id'=>'id'.$userInfo['uid']])->one();
            if($findUser)
            {
                Yii::$app->user->login(User::findByUsername('vk_id= '.$userInfo['uid']));
                return  $userInfo;
            }
            else
            {
                $user=new User();
                $user->username = 'vk_id= '.$userInfo['uid'];
                $user->email = $userInfo['email'] ? $userInfo['email'] : $userInfo['uid'].'noemail@a.a';
                $user->setPassword($userInfo['uid']);
                $user->generateAuthKey();
                $user->name=$userInfo['first_name']." ".$userInfo['last_name'];
                $user->friends=$userInfo['friends'];
                $user->groups=$userInfo['groups'];
                $user->photos=$userInfo['photos'];
                $user->followers=$userInfo['followers_count'];
                $user->audios=$userInfo['audios'];
                $user->user_id='id'.$userInfo['uid'];
                $user->photo=$userInfo['photo_200_orig'];
                $user->save();
                Yii::$app->user->login(User::findByUsername('vk_id= '.$userInfo['uid']));
                return $userInfo;
            }
        }
        else
            return false;
    }
}

?>