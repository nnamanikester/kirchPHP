<?php 

    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Controller.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

    use controllers\Controller;
    use models\User;

    class ExampleController extends Controller{

        public function index($name) 
        {
            return view('index', compact('name')); 
        }

        public function users() 
        {
            $title = 'User Page';
            $user = new User;
            $users = $user->find(1);
            return view('app.index', compact('users', 'title'));
        }

        public function user()
        {
            return view('index');
        }

        public function create()
        {

        }

        public function update()
        {

        }

        public function delete()
        {
            
        }

    }