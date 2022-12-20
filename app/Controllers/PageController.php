<?php

namespace App\Controllers;

use ORM;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\PhpRenderer;

class PageController
{
    public function footer (){
        $f_categories = ORM::forTable('categories')->select('*')->orderByDesc('categories.name')->limit(4)->findMany();
        return $f_categories;
    }
    public function index(Request $request, Response $response, $args) //Фунция выполняющая действия на странице index
    {
        $f_categories = $this->footer();
        $renderer = new PhpRenderer('resources');
        $jobs_list = ORM::for_table('jobs')// Запрос для получения "Список работ"
            ->select('jobs.id')
            ->select('jobs.name')
            ->select('jobs.date')
            ->select('job_types.name','job_type')
            ->select('locations.name','location')
            ->select('firms.src','img')
            ->innerJoin( 'job_types', array('jobs.id_job_types','=','job_types.id'))
            ->innerJoin( 'locations', array('jobs.id_locations','=','locations.id'))
            ->innerJoin( 'firms', array('jobs.id_firm','=','firms.id'))
            ->orderByDesc('jobs.date')
            ->limit(6)
            ->findMany();
        $categories = ORM::for_table('categories') //Запрос для получения "Популярные категории"
            ->raw_query('SELECT categories.id, categories.name, COUNT(jobs.id_categories) 
            FROM categories LEFT JOIN jobs ON categories.id = jobs.id_categories GROUP BY categories.id ORDER BY COUNT(jobs.id_categories) DESC LIMIT 8')
            ->findMany();
        $count = ORM::forTable('jobs')->count('jobs.id');//Запрос для получения "Количество вакансий"

        $top_firms = ORM::forTable('firms')->raw_query('SELECT firms.id, firms.name, firms.src, COUNT(jobs.id_firm) 
from firms LEFT JOIN jobs ON jobs.id_firm = firms.id GROUP BY firms.id ORDER BY COUNT(jobs.id_firm) DESC LIMIT 4')->findMany();
        return $renderer->render($response, "index.php", ['popular_categories' => $categories, 'jobs_list'=>$jobs_list, 'count'=>$count, 'f_categories'=>$f_categories, 'top_firms'=>$top_firms]);// Точка соединения функции и страницы
    }

    public function job_details(Request $request, Response $response, $args) //Фунция выполняющая действия на странице job_details
    {

        $renderer = new PhpRenderer('resources');
        $id= $args['id'];// Объявление переменной берущая значение из id выбранной вакансии
$job = ORM::forTable('jobs') // Запрос для получения данных о выбранной на странице jobs работе
    ->select('jobs.id')
    ->select('jobs.name','name')
    ->select('jobs.description')
    ->select('locations.name','l_name')
    ->select('job_types.name','types_name')
    ->select('firms.src','img')
    ->select('jobs.date')
    ->select('jobs.Salary')
    ->innerJoin( 'locations', array('jobs.id_locations','=','locations.id'))
    ->innerJoin( 'job_types', array('jobs.id_job_types','=','job_types.id'))
    ->innerJoin( 'firms', array('jobs.id_firm','=','firms.id'))
    ->where('jobs.id',[$id])
    ->findOne();
        $f_categories = $this->footer();

        return $renderer->render($response, "job_details.php", ['job' => $job, 'f_categories'=>$f_categories]);

    }
    public function jobs(Request $request, Response $response, $args) //  //Фунция выполняющая действия на странице jobs
    {
        $renderer = new PhpRenderer('resources');

// Переменные берущие данные из формы фильтра и имеющие начальные значения для вывода всех данных из базы
        $f_categories = $this->footer();
        $loc = $_GET['loc']??'>=1';
        $cat = $_GET['cat']??'>=1';
        $exp = $_GET['exp']??'>=1';
        $job_t = $_GET['job_t']??'>=1';
        $qual = $_GET['qual']??'>=1';
        $gen = $_GET['gen']??'>=1';
        $name = $_GET['name']??'';
            $jobs = ORM::forTable('jobs')// Запрос для фильтра, выводит данные в соответсвии с выбранными значениями в форме "Фильтр"
                ->raw_query("SELECT jobs.id, jobs.name, locations.name AS l_name, job_types.name as types_name, firms.src, jobs.date,
           jobs.Salary, categories.name as cat_name, experiences.name as e_name, qualifications.name as q_name, gender.name as g_name
        FROM jobs
        INNER JOIN job_types ON jobs.id_job_types = job_types.id
        INNER JOIN locations ON locations.id = jobs.id_locations
        INNER JOIN firms ON firms.id = jobs.id_firm
        INNER JOIN gender ON jobs.id_gender = gender.id
        INNER JOIN experiences ON experiences.id = jobs.id_experiences
        INNER JOIN categories ON categories.id = jobs.id_categories
        INNER JOIN qualifications ON qualifications.id = jobs.id_qualifications
        WHERE id_categories {$cat}  AND
        id_experiences {$exp} AND
        id_locations {$loc} AND
        id_gender {$gen} AND
        id_qualifications {$qual} AND
        id_job_types {$job_t} AND
        jobs.name LIKE '{$name}%';
        ")->findMany();
        $categories = ORM::forTable('categories')// Запрос для вывода всех существующих категорий в поле формы "Фильтр"
            ->select('*')
            -> findMany();
        $genders = ORM::forTable('gender')// Запрос для вывода всех существующих гендеров в поле формы "Фильтр"
            ->select('*')
            -> findMany();
        $qualifications = ORM::forTable('qualifications')// Запрос для вывода всех существующих квалификаций в поле формы "Фильтр"
            ->select('*')
            -> findMany();
        $job_types = ORM::forTable('job_types')// Запрос для вывода всех существующих типов работ в поле формы "Фильтр"
            ->select('*')
            -> findMany();
        $experiences = ORM::forTable('experiences') // Запрос для вывода опыта в поле формы "Фильтр"
            ->select('*')
            -> findMany();
        $locations= ORM::forTable('locations')// Запрос для вывода Местоположения в поле формы "Фильтр"
            ->select('*')
            -> findMany();
        $count = ORM::forTable('jobs')->count('jobs.id'); // Запрос для подсчета существующих вакансий

        return $renderer->render($response, "jobs.php", ['jobs'=>$jobs, 'categories'=>$categories, 'genders'=>$genders, 'qualifications'=>$qualifications,
            'job_types'=>$job_types, 'experiences'=>$experiences, 'locations'=>$locations, 'loc'=>$loc, 'cat'=>$cat, 'exp'=>$exp,'job_t'=>$job_t, 'qual'=>$qual, 'gen'=>$gen, 'name'=>$name,'count'=>$count, 'f_categories'=>$f_categories]);
    }
    public function form(Request $request, Response $response, $args)// Функция выполняющая действия формы
    {
        // Создание переменных из полей  запроса
        $name= $_POST['name']; // Имя заявителя
        $id = $_POST['id']; // id выбранной вакансии
        $name_job = ORM::forTable('jobs') // Запрос название вакансии по id
            ->select('jobs.name')
            ->where('jobs.id', $id)
            ->findOne();
        $email= $_POST['email']; // Почта заявителя
        $port_link= $_POST['port_link']; // Ссылка на резюме заявителя
        $text= $_POST['text']; // Описание заявителя
        mail($email, 'Job:'.$name_job->name."\n", 'name: '. $name."\n".'portfolio: '.$port_link."\n".$text,'From: denikovi@list.ru'); // Функция отправки сообщения на почту
       $person = ORM::forTable('applies')->create();
       $person->name = $name;
       $person->email = $email;
       $person->link = $port_link;
       $person -> coverletter = $text;
       $person->jobs_id = $id;
       $person->save();
        return $response->withStatus(302)->withHeader('Location', '/jobs');
    }

}