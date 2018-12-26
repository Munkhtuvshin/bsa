<?php
// __FILE__ тухайн файлын бүтэн замыг хадгалах хувьсагч
// Жишээ нь: __FILE__ => /home/zolboo/Projects/eschool/index.php
// dirname() тухайн файл болон хавтасны эх хавтасны замыг буцаана
// define() тогтмол хувсагч зарлана
// Прожектын үндсэн байрлалыг хадгалах ROOT нэртэй тогтмол зарлаж байна
// define('ROOT','/home/zolboo/Projects/eschool');
define('ROOT', dirname(__FILE__));
require_once ROOT . '/model/user/User.php';
User::loadCurrentUser();
// $_SERVER хэрэглэгчээс ирсэн хүсэлтийн мэдээллийг агуулна
// $_SERVER["REQUEST_URI"] хэрэглэгчийн хандсан URL хаяг агуулна
// https://localhost:8080/ => /
// https://localhost:8080/todo/todo => /todo/todo
// Хэрэглэгчийн хандсан хаягийг $url хувьсагчид хадгална
$url = $_SERVER["REQUEST_URI"];
// GET хувьсагч буюу ? тэмдэгтээс хойших утгыг арилгана
$url = preg_split('/\?/i', $url)[0];
// Regular Expression тодорхой загварын дагуу тэмдэгт мөрийг тодорхойлно
// preg_split() тодорхой загварын тэмдэгтээр тухайн тэмдэгт мөрийг хуваана
// Хэрэглэгчийн хандсан хаягийг / тэмдэгтээр тасалж авна
// $url => /    =>  $parts => ['', '']
// $url => /todo    =>  $parts => ['', 'todo']
// $url => /todo/todo    =>  $parts => ['', 'todo', 'todo']
// $url => /todo/todo/    =>  $parts => ['', 'todo', 'todo', '']
$parts = preg_split('/\//i', $url);
if($url == '/') { // Нүүр хуудасруу надсан эсэхийг шалгана
    // localhost:8080
    // hereglegch nevtreegui bol login huudsiig duudna.
    // nevtersen bol NewsFeed-g duudna
    if (User::getMe() == NULL) {
        header("Location: /user/user/sign-in");
    } else {
        header("Location: /newsfeed/news-feed");
    }
} else  { // Нүүрээс өөр хуудас бол
    // localhost:8080/todo
    // TodoController->index() functioniig automataar duudna.
    // ucwords() тэмдэгт мөрийн үг бүрийн эхний үсгийг томруулна
    // Хэрэглэгчийн хандсан контроллёр классын нэрийг үүсгэнэ
    // $controllerName => TodoController
    // my-first-class => ucwords(my first class) => My First Class => MyFirstClass
    // var_dump($parts[1]);
    $controllerName = preg_replace('/\s/i', '', ucwords(preg_replace('/\-/i', ' ', $parts[2])));
    $controllerName .= 'Controller'; // TodoController, MyFirstClassController
    // require_once php файлыг импорт хийнэ
    // require_once /home/zolboo/Projects/eschool/controller/todo/TodoController.php
    require_once ROOT . '/controller/' . $parts[1] . '/' . $controllerName . '.php';
    
    // new түлхүүр үгийн ард хувьсагч байвал тухайн хувьсагчийн утгыг классын нэр гэж үзнэ
    $controller = new $controllerName(); // new TodoController();
    // var_dump($controller);
    if(count($parts) == 3){
        $controller->index();
    } else {
        // localhost:8080/todo/add
        // TodoController->add() functioniig duudna.
        $methodName = lcfirst(preg_replace('/\s/i', '', ucwords(preg_replace('/\-/i', ' ', $parts[3]))));
        if(count($parts) == 4){
            $controller->$methodName(); // $controller->add()
        } else if(count($parts) > 4){
            // localhost:8080/todo/edit/1
            // $controller->$methodName($parts[4]); // $controller->edit(1)
            // array_slice(массив,эхлэл,урт,preserve)  массивийн тодорхой хэсгийг авна
            // 3 дахь хэсгээс хойш буюуу функцийн параметрүүдийг $params хувьсагчид олгоно
            $params = array_slice($parts, 4);
            call_user_func_array(array($controller, $methodName), $params);
        }
    }
}