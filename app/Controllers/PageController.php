<?php

namespace App\Controllers;

use ORM;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\PhpRenderer;

class PageController
{
    public function index(Request $request, Response $response, $args)
    {
        $renderer = new PhpRenderer('resources');
        $jobs_list = ORM::for_table('jobs')
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

        $categories = ORM::for_table('categories')->raw_query('SELECT categories.id, categories.name, COUNT(jobs.id_categories) FROM categories LEFT JOIN jobs ON categories.id = jobs.id_categories GROUP BY categories.id ORDER BY COUNT(jobs.id_categories) DESC LIMIT 8')->findMany();
    //    $jobs_list = ORM::for_table('categories')->raw_query('SELECT jobs.id, jobs.name, locations.name AS l_name, job_types.name as types_name, firms.src, jobs.date
        // FROM jobs
        // INNER JOIN job_types ON jobs.id_job_types = job_types.id
        // INNER JOIN locations ON locations.id = jobs.id_locations
        // INNER JOIN firms ON firms.id = jobs.id_firm
        // ORDER BY `jobs`.`date` DESC LIMIT 6')->findMany();
        $count = ORM::forTable('jobs')->count('jobs.id');
        return $renderer->render($response, "index.php", ['popular_categories' => $categories, 'jobs_list'=>$jobs_list, 'count'=>$count]);
    }

    public function job_details(Request $request, Response $response, $args)
    {
        $renderer = new PhpRenderer('resources');
        $id= $args['id'];
$job = ORM::forTable('jobs')
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

   //     $job = ORM::for_table('job')->raw_query("
        //SELECT jobs.id, jobs.name as name,jobs.description, locations.name AS l_name, job_types.name as types_name, firms.src, jobs.date, jobs.Salary
        // FROM jobs
        // INNER JOIN job_types ON jobs.id_job_types = job_types.id
        // INNER JOIN locations ON locations.id = jobs.id_locations
        // INNER JOIN firms ON firms.id = jobs.id_firm
        // WHERE jobs.id={$id}")->findOne();

        return $renderer->render($response, "job_details.php", ['job' => $job]);

    }
    public function footer(Request $request, Response $response, $args)
    {
        $categories = ORM::forTable('categories')
            ->select('categories.name')
            ->count('jobs.id_categories');


    }
    public function jobs(Request $request, Response $response, $args)
    {
        $renderer = new PhpRenderer('resources');

        $loc = $_GET['loc']??'>=1';
        $cat = $_GET['cat']??'>=1';
        $exp = $_GET['exp']??'>=1';
        $job_t = $_GET['job_t']??'>=1';
        $qual = $_GET['qual']??'>=1';
        $gen = $_GET['gen']??'>=1';
        $name = $_GET['name']??'';


            $jobs = ORM::forTable('jobs')->raw_query("SELECT jobs.id, jobs.name, locations.name AS l_name, job_types.name as types_name, firms.src, jobs.date,
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
//        $jobs = ORM::forTable('jobs')
//            ->select('jobs.id')
//            ->select('jobs.name')
//            ->select('locations.name','l_name')
//            ->select('job_types.name','types_name')
//            ->select('firms.src')
//            ->select('jobs.date')
//            ->select('jobs.Salary')
//            ->select('categories.name','cat_name')
//            ->select('experiences.name','e_name')
//            ->select('qualifications.name','q_name')
//            ->select('gender.name','g_name')
//            ->innerJoin('job_types',array('jobs.id_job_types','=','job_types.id'))
//            ->innerJoin('locations',array('locations.id','=','jobs.id_locations'))
//            ->innerJoin('firms',array('firms.id','=','jobs.id_firm'))
//            ->innerJoin('gender',array('gender.id','=','jobs.id_gender'))
//            ->innerJoin('experiences',array('experiences.id','=','jobs.id_experiences'))
//            ->innerJoin('categories',array('categories.id','=','jobs.id_categories'))
//            ->innerJoin('qualifications',array('qualifications.id','=','jobs.id_qualifications'))
//            ->where('id_categories',$cat)
//            ->where('id_experiences',$exp)
//            ->where('id_locations',$loc)
//            ->where('id_gender',$gen)
//            ->where('id_qualifications',$qual)
//            ->where('id_job_types',$job_t)
//            ->where_like('jobs.name',$name.'%')->findMany();
//        var_dump($jobs);
      //  $categories = ORM::forTable('categories')-> raw_query('SELECT * FROM categories')->findMany();
        $categories = ORM::forTable('categories')
            ->select('*')
            -> findMany();
        $genders = ORM::forTable('gender')
            ->select('*')
            -> findMany();
        $qualifications = ORM::forTable('qualifications')
            ->select('*')
            -> findMany();
        $job_types = ORM::forTable('job_types')
            ->select('*')
            -> findMany();
        $experiences = ORM::forTable('experiences')
            ->select('*')
            -> findMany();
        $locations= ORM::forTable('locations')
            ->select('*')
            -> findMany();
        $count = ORM::forTable('jobs')->count('jobs.id');

        return $renderer->render($response, "jobs.php", ['jobs'=>$jobs, 'categories'=>$categories, 'genders'=>$genders, 'qualifications'=>$qualifications,
            'job_types'=>$job_types, 'experiences'=>$experiences, 'locations'=>$locations, 'loc'=>$loc, 'cat'=>$cat, 'exp'=>$exp,'job_t'=>$job_t, 'qual'=>$qual, 'gen'=>$gen, 'name'=>$name,'count'=>$count]);
    }
    public function form(Request $request, Response $response, $args){
        $name= $_POST['name'];
        $id = $_POST['id'];
        $name_job = ORM::forTable('jobs')->select('jobs.name')->where('jobs.id', $id)->findOne();
        $email= $_POST['email'];
        $port_link= $_POST['port_link'];
        $text= $_POST['text'];
        mail($email, 'Job:'.$name_job->name."\n", 'name: '. $name."\n".'portfolio: '.$port_link."\n".$text,'From: denikovi@list.ru');
        return $response->withStatus(302)->withHeader('Location', '/jobs');
    }

}